<?php

namespace App\Orchid\Screens\Bot\KeyBoard;

use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class KeyBoardListScreen extends Screen
{

    public $name = 'Список клавиатур';
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

            Link::make('Создать клавиатуру')
                ->route('bot.keyboard.edit', $this->request->bot)
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
