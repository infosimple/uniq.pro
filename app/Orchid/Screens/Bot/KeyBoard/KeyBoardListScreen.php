<?php

namespace App\Orchid\Screens\Bot\KeyBoard;

use App\Models\Bot\Bot;
use App\Models\Bot\KeyBoard;
use App\Orchid\Layouts\Bot\KeyBoard\KeyBoardListLayout;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button as OButton;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class KeyBoardListScreen extends Screen
{

    public $name = 'Список клавиатур';
    public $description = "";

    /**
     * Получаем id бота
     */
    public $id = '';

    public function query(Request $request): array
    {
        $this->id = $request->bot;
        $this->description = Bot::find($this->id)->name;

        return [
            'key_boards' => KeyBoard::where('bot_id', $this->id)->paginate(10)
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
            Link::make('Создать клавиатуру')
                ->route('bot.keyboard.edit', $this->id)
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
            KeyBoardListLayout::class
        ];
    }
    public function remove(Request $request)
    {
        KeyBoard::findOrFail($request->get('id'))
            ->delete();
        Alert::info('Вы успешно удалили клавиатуру!');
        return back();
    }

}
