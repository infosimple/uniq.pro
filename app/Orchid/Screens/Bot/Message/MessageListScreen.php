<?php

namespace App\Orchid\Screens\Bot\Message;

use App\Models\Bot\Bot;
use App\Models\Bot\Message;
use App\Orchid\Layouts\Bot\Message\MessageListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class MessageListScreen extends Screen
{

    public $name = 'Список сообщений';
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
            'message' => Message::with(['group', 'keyboard'])
                ->filters()
                ->where('bot_id', $this->id)
                ->paginate(10)
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

            Link::make('Создать сообщение')
                ->route('bot.message.edit', $this->id)
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
            MessageListLayout::class
        ];
    }
    public function remove(Request $request)
    {
        Message::findOrFail($request->get('id'))
            ->delete();
        Alert::info('Вы успешно удалили сообщение!');
        return back();
    }
}
