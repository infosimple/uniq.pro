<?php

namespace App\Orchid\Screens\Bot\KeyBoard;

use App\Models\Bot\Bot;
use Orchid\Screen\Actions\Button;
use App\Models\Bot\Button as MButton;
use App\Models\Bot\KeyBoard;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
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

    public function query(Request $request, KeyBoard $keyboard = null): array
    {
        if (!$keyboard) {
            abort(404);
        }
        $this->exists = $keyboard->exists;

        if ($this->exists) {
            $this->name = 'Изменение клавиатуры: ' . $keyboard->name;
            $keyboard->buttons = json_decode($keyboard->buttons);
        }
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;

        return [
            'keyboard' => $keyboard
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
                Select::make('keyboard.buttons.0.')
                    ->multiple()
                    ->fromQuery(MButton::where('bot_id', $this->id), 'command')
                    ->title('Первый ряд кнопок')
                    ->help('Не более 4 шт'),
                Select::make('keyboard.buttons.1.')
                    ->multiple()
                    ->fromQuery(MButton::where('bot_id', $this->id), 'command')
                    ->title('Второй ряд кнопок'),
                Select::make('keyboard.buttons.2.')
                    ->multiple()
                    ->fromQuery(MButton::where('bot_id', $this->id), 'command')
                    ->title('Третий ряд кнопок'),
                Select::make('keyboard.buttons.3.')
                    ->multiple()
                    ->fromQuery(MButton::where('bot_id', $this->id), 'command')
                    ->title('Четвертый ряд кнопок'),
                Select::make('keyboard.buttons.4.')
                    ->multiple()
                    ->fromQuery(MButton::where('bot_id', $this->id), 'command')
                    ->title('Пятый ряд кнопок')
            ]),

        ];
    }

    public function createOrUpdate(Request $request, KeyBoard $keyboard)
    {
        $message = [
            'keyboard.buttons.required' => 'Необходимо выбрать хотябы одну кнопку',
            'keyboard.buttons.*.max' => 'Не более :max кнопок в строке',
        ];
        $request->validate([
            'keyboard.buttons.*' => 'max:4',
           'keyboard.buttons' => 'required'
        ], $message);

        $data = $request->keyboard; //Получаем все данные клавиатуры
        $data['buttons'] = collect($data['buttons'])->values()->toJson(); //декодируем кнопки в json
        $keyboard->fill($data)->save();


        if ($request->id == 'createOrUpdate') {
            Alert::info('Вы успешно создали клавиатуру: ' . $data['name']);
            return redirect()->route('bot.keyboard.list', $request->bot);
        } else {
            Alert::info('Вы успешно изменили клавиатуру');
            return redirect()->route('bot.keyboard.edit', [$request->bot, $request->id]);
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
