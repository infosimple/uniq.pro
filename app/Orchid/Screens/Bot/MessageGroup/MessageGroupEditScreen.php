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
            $messageGroup->messages = json_decode($messageGroup->messages);
            // dd($messageGroup);
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
                Select::make('messagegroup.messages.0')
                    ->title('Сообщение 1')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.1')
                    ->title('Сообщение 2')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.2')
                    ->title('Сообщение 3')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.3')
                    ->title('Сообщение 4')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.4')
                    ->title('Сообщение 5')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.5')
                    ->title('Сообщение 6')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.6')
                    ->title('Сообщение 7')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.7')
                    ->title('Сообщение 8')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.8')
                    ->title('Сообщение 9')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
                Select::make('messagegroup.messages.9')
                    ->title('Сообщение 10')
                    ->fromQuery(Message::where('bot_id', $this->id), 'name')
                    ->empty(),
            ])
        ];
    }

    public function createOrUpdate(Request $request, MessageGroup $messageGroup)
    {

        $data = $request->messagegroup;
        $cnt = collect($data['messages'])
            ->filter()
            ->count();
        if($cnt < 2){
            Alert::error('В группе должно быть не менее 2 сообщений');
            return back();
        }

        $data['messages'] = collect($data['messages'])
            ->filter()
            ->values()
            ->toJson();

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
