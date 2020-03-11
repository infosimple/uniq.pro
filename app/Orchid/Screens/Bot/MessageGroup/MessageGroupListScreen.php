<?php

namespace App\Orchid\Screens\Bot\MessageGroup;

use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MessageGroupListScreen extends Screen
{

    public $name = 'Список груп сообщений';
    public $description = "";

    /**
     * Получаем id бота
     */
    public $idBot = "";

    public function query(Request $request): array
    {
        $this->idBot = $request->bot;
        $this->description = Bot::find($this->idBot)->name;
        return [];
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
        return [];
    }
}
