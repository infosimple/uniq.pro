<?php

namespace App\Orchid\Screens\Bot\KeyBoard;

use App\Models\Bot\Bot;
use Orchid\Screen\Actions\Button;
use App\Models\Bot\Button as MButton;
use App\Models\Bot\KeyBoard;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class KeyBoardEditScreen extends Screen
{
    public $name = 'Создание клавиатуры';
    public $description = '';

    /**
     * Получаем id бота
     */
    private $id = '';
    /**
     * Проверка на создание или редактирование кнопки
     */
    public $exists = false;

    public function query(Request $request, KeyBoard $keyBoard = null): array
    {
        if (!$keyBoard) {
            abort(404);
        }
        $this->exists = $keyBoard->exists;

        if ($this->exists) {
            $this->name = 'Изменение клавиатуры: ' . $keyBoard->name;
        }
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;
        return [
            'keyBoard' => $keyBoard
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
                ->route('bot.keyboard.list', $this->id)
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
                Input::make('keyboard.bot_id')
                    ->type('hidden')
                    ->value($this->id),
                Input::make('keyboard.name')
                    ->title('Название клавиатуры')
                    ->placeholder('Главная клава')
                    ->help('Укажите название будущей клавиатуры')
                    ->required(),
                    Select::make('keyboard.buttons')
                        ->fromQuery(MButton::where('bot_id', $this->id), 'name', 'id')
                        ->empty('Не выбрано'),
                    Select::make('keyboard.buttons')
                        ->fromQuery(MButton::where('bot_id', $this->id), 'name', 'id'),
                    Select::make('keyboard.buttons')
                        ->multiple()
                        ->fromQuery(MButton::where('bot_id', $this->id), 'name', 'id')
            ]),

        ];
    }

    public function createOrUpdate(Request $request, KeyBoard $keyboard)
    {
        $data = $request->keyboard; //Получаем все данные кнопки
        // Если есть методы, то преобразуем их в массив и добавляем в кнопку
        dd($data);
        $keyboard->fill($data)->save();
        Alert::info('Вы успешно создали кнопку: ' . $data['name']);
        if ($request->id == 'createOrUpdate') {
            return redirect()->route('bot.button.list', $request->bot);
        } else {
            return redirect()->route('bot.button.edit', [$request->bot, $request->id]);
        }
    }

    public function remove(Request $request, KeyBoard $keyboard)
    {
        $keyboard->delete()
            ? Alert::info('Вы успешно удалили клавиатуру')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bot.keyboard.list', $request->bot);
    }

}
