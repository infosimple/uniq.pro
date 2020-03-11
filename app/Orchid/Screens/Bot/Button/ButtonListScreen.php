<?php

namespace App\Orchid\Screens\Bot\Button;

use App\Models\Bot\Bot;
use App\Models\Bot\Button;
use App\Orchid\Layouts\Bot\Button\ButtonListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ButtonListScreen extends Screen
{

    public $name = 'Список кнопок';
    public $description = "";

    /**
     * Получаем id бота
     */
    public $idBot = "";

    public function query(Request $request): array
    {
        $this->idBot = $request->bot;
        $this->description = Bot::find($this->idBot)->name;

        return [
            'button' => Button::where('bot_id', $request->bot)->paginate()
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

            Link::make('Создать кнопку')
                ->route('bot.button.edit', $this->request->bot)
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
            ButtonListLayout::class
        ];
    }

    public function remove(Request $request)
    {
        Button::findOrFail($request->get('id'))
            ->delete();
         Alert::info('Вы успешно удалили кнопку!');
        return back();
    }
}
