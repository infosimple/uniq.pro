<?php

namespace App\Orchid\Screens\Bot\Telegram;

use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class BotEditScreen extends Screen
{

    public $name = 'Создание Telegram бота';
    public $description = 'Еще один бот';

    //Переменная определяющая редактирование или создание бота
    public $exists = false;



    public function query(Bot $bot): array
    {
        $this->exists = $bot->exists;
        if ($this->exists) {
            $this->name = $bot->name;
            $this->description = 'Изменение бота';
        }

        return [
            'bot' => $bot
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
                ->class('btn btn-error btn-block')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        //Форма телеграма
        return [
            $telegram = Layout::rows([
                Input::make('bot.name')
                    ->title('Название бота')
                    ->placeholder('Телеграмм бот')
                    ->help('Укажите название будущего бота'),
            ])
        ];
    }

    public function createOrUpdate(Bot $bot, Request $request)
    {
        dd($request->bot);
    }
}
