<?php

namespace App\Orchid\Screens\Bot\MessageGroup;

use App\Models\Bot\Bot;
use App\Models\Bot\Message;
use App\Models\Bot\MessageGroup;
use App\Orchid\Layouts\Bot\MessageGroup\MessageGroupListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class MessageGroupListScreen extends Screen
{

    public $name = 'Список груп сообщений';
    public $description = "";

    /**
     * Получаем id бота
     */
    public $id = "";


    public function query(Request $request): array
    {
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;
        return [
            'messagegroup' => MessageGroup::where('bot_id', $this->id)->paginate(10),
            'message' => Message::where('bot_id', $this->id)
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
                ->route('bots.list')
                ->icon('icon-arrow-left')
                ->class('btn btn-default'),

            Link::make('Создать группу сообщений')
                ->route('bot.messagegroup.edit', $this->request->bot)
                ->icon('icon-plus')
                ->class('btn btn-success')
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
            MessageGroupListLayout::class
        ];
    }

    public function remove(Request $request)
    {
        MessageGroup::findOrFail($request->get('id'))
            ->delete();
        Alert::info('Вы успешно удалили группу сообщений!');
        return back();
    }
}
