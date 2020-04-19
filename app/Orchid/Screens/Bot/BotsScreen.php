<?php

namespace App\Orchid\Screens\Bot;

use App\Models\Bot\Bot;
use App\Orchid\Layouts\Bot\BotListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class BotsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список всех ботов';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Telegram/Vk боты';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        return [
            'bot' => Bot::with(['button', 'keyboard', 'message', 'messagegroup'])->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        $buttons = [];
        $bots = Bot::all();
        $vkBot = $bots->where('soc', 'vk')->first();
        $telegramBot = $bots->where('soc', 'telegram')->first();
        if (!$vkBot) {
            $buttons[] = Link::make('Вконтакте бот')
                ->route('bot.vk.create')
                ->icon('icon-plus')
                ->class('btn btn-success');
        }
        if (!$telegramBot) {
            $buttons[] = Link::make('Telegram бот')
                ->route('bot.telegram.create')
                ->icon('icon-plus')
                ->class('btn btn-info');
        }

        return $buttons;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            BotListLayout::class
        ];
    }

    public function remove(Request $request)
    {

        Bot::findOrFail($request->id)
            ->delete();
        Alert::info('Вы успешно удалили бота!');
        return back();
    }
}
