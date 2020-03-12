<?php

namespace App\Orchid\Screens\Bot\Button;

use App\Models\Bot\Bot;
use App\Models\Bot\Button as MButton;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class ButtonEditScreen extends Screen
{
    public $name = 'Создание кнопки';
    public $description = '';

    /**
     * Получаем id бота
     */
    private $id = '';
    /**
     * Проверка на создание или редактирование кнопки
     */
    public $exists = false;


    public function query(Request $request, MButton $button = null): array
    {
        if (!$button){
            abort(404);
        }
        $this->exists = $button->exists;

        if ($this->exists) {
            $this->name = 'Изменение кнопки: ' . $button->name;
            $button->methods = collect($button->methods)->implode("\n");
        }
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;
        return [
            'button' => $button
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {

        return [
            Link::make('Назад')
                ->route('bot.button.list', $this->id)
                ->icon('icon-arrow-left')
                ->class('btn btn-default'),

            Button::make('Создать')
                ->icon('icon-plus')
                ->class('btn btn-success btn-block')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('icon-note')
                ->class('btn btn-warning btn-block')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('icon-trash')
                ->class('btn btn-danger btn-block')
                ->method('remove')
                ->canSee($this->exists)
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('button.bot_id')
                    ->type('hidden')
                    ->value($this->id),
                Input::make('button.name')
                    ->title('Название кнопки')
                    ->placeholder('Купить')
                    ->help('Укажите название будущей кнопки')
                    ->required(),
                Input::make('button.command')
                    ->title('Команда')
                    ->placeholder('btn-1')
                    ->help('Укажите идентификатор кнопки')
                    ->required(),
                Select::make('button.color')
                    ->title('Цвет кнопки')
                    ->options([
                        'green' => 'Зеленый',
                        'blue' => 'Синий',
                        'red' => 'Красный'
                    ])
                    ->empty('Белый', 'white')
                    ->required(),
                TextArea::make('button.methods')
                    ->placeholder("message: 3\rexit\rmessagegropup")
                    ->max(255)
                    ->rows(5)
                    ->title('Каждая строка, новая функция'),
            ])

        ];
    }

    public function createOrUpdate(Request $request, MButton $button)
    {
        $dataButton = $request->button; //Получаем все данные кнопки
        $methods = $dataButton['methods']; //Получаем только методы
        // Если есть методы, то преобразуем их в массив и добавляем в кнопку
        if ($methods) {
            $methods = explode("\r\n", $methods);
            $dataButton['methods'] = $methods;
        }
        $button->fill($dataButton)->save();

        if ($request->id == 'createOrUpdate') {
            Alert::info('Вы успешно создали кнопку: ' . $dataButton['name']);
            return redirect()->route('bot.button.list', $request->bot);
        }else{
            Alert::info('Вы успешно изменили кнопку');
            return redirect()->route('bot.button.edit', [$request->bot, $request->id]);
        }
    }

    public function remove(Request $request, MButton $button)
    {
        $button->delete()
            ? Alert::info('Вы успешно удалили кнопку')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bot.button.list', $request->bot);
    }

}
