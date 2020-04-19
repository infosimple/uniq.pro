<?php

namespace App\Orchid\Screens\Bot\MessageGroup;

use App\Models\Bot\Bot;
use App\Models\Bot\KeyBoard;
use App\Models\Bot\Message;
use App\Models\Bot\MessageGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class MessageGroupEditScreen extends Screen
{
    public $name = 'Создание группы сообщений';
    public $description = '';

    /**
     * Получаем id бота
     */
    private $id = '';
    /**
     * Проверка на создание или редактирование кнопки
     */
    public $exists = false;

    public function query(Request $request, MessageGroup $messageGroup = null): array
    {
        if (!$messageGroup) {
            abort(404);
        }

        $this->exists = $messageGroup->exists;

        if ($this->exists) {
            $this->name = 'Изменение группы сообщений: ' . $messageGroup->name;
        }
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;

        return [
            'messagegroup' => $messageGroup
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
                ->route('bot.messagegroup.list', $this->id)
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
                Input::make('messagegroup.bot_id')
                    ->type('hidden')
                    ->value($this->id),
                Input::make('messagegroup.name')
                    ->title('Название группы сообщений')
                    ->placeholder('Рассылка задания')
                    ->required(),
            ])
        ];
    }

    public function createOrUpdate(Request $request, MessageGroup $messageGroup)
    {

        $data = $request->messagegroup;
        $messageGroup->fill($data)->save();

        if ($request->id == 'createOrUpdate') {
            Alert::info('Вы успешно создали группу сообщений: ' . $data['name']);
            return redirect()->route('bot.messagegroup.list', $request->bot);
        } else {
            Alert::info('Вы успешно изменили группу сообщений');
            return redirect()->route('bot.messagegroup.edit', [$request->bot, $request->id]);
        }

    }

    public function remove(Request $request, MessageGroup $messageGroup)
    {
        $messageGroup->delete()
            ? Alert::info('Вы успешно удалили группу сообщений')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bot.messagegroup.list', $request->bot);
    }
}
