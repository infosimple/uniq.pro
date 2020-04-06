<?php

namespace App\Orchid\Screens\Bot\Message;

use App\Models\Bot\Bot;
use App\Models\Bot\KeyBoard;
use App\Models\Bot\Message;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\TinyMCE;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class MessageEditScreen extends Screen
{
    public $name = 'Создание сообщения';
    public $description = '';

    /**
     * Получаем id бота
     */
    private $id = '';
    /**
     * Проверка на создание или редактирование кнопки
     */
    public $exists = false;

    public function query(Request $request, Message $message = null): array
    {
        if (!$message) {
            abort(404);
        }
        $this->exists = $message->exists;

        if ($this->exists) {
            $this->name = 'Изменение сообщения: ' . $message->name;
        }
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;

        return [
            'message' => $message
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
                ->route('bot.message.list', $this->id)
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
                Input::make('message.bot_id')
                    ->type('hidden')
                    ->value($this->id),
                Input::make('message.name')
                    ->title('Название сообщения')
                    ->placeholder('Приветсвтие')
                    ->required(),
                SimpleMDE::make('message.text')
                    ->title('Текст сообщения')
                    ->placeholder('Добро пожаловать мой друг'),
                Select::make('message.keyboard_id')
                    ->title('Клавиатура')
                    ->fromQuery(KeyBoard::where('bot_id', $this->id), 'name')
                    ->empty(),
                Input::make('message.method')
                    ->title('Метод обработки сообщения')
                    ->help("email или start"),
                TextArea::make('message.method_text')
                    ->title('Текст если не выполнен метод')
            ])
        ];
    }

    public function createOrUpdate(Request $request, Message $message)
    {
        $data = $request->message;
        $message->fill($data)->save();
        if ($request->id == 'createOrUpdate') {
            Alert::info('Вы успешно создали сообщение: ' . $data['name']);
            return redirect()->route('bot.message.list', $request->bot);
        } else {
            Alert::info('Вы успешно изменили сообщение');
            return redirect()->route('bot.message.edit', [$request->bot, $request->id]);
        }

    }

    public function remove(Request $request, Message $message)
    {
        $message->delete()
            ? Alert::info('Вы успешно удалили сообщение')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bot.message.list', $request->bot);
    }

}
