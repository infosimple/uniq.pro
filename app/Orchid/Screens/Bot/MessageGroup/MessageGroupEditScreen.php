<?php

namespace App\Orchid\Screens\Bot\MessageGroup;

use App\Models\Bot\Bot;
use App\Models\Bot\MessageGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MessageGroupEditScreen extends Screen
{
    public $name = 'Создание группы сообщений';
    public $description = '';

    /**
     * Получаем id бота
     */
    public $idBot = "";
    /**
     * Проверка на создание или редактирование группы сообщений
     */
    public $exists = false;

    public function query(Request $request, MessageGroup $messageGroup): array
    {        $this->exists = $messageGroup->exists;

        if($this->exists){
            $this->name = 'Изменение группы сообщений: ' . $messageGroup->name;
        }

        $this->idBot = $request->bot;
        $this->description = Bot::find($this->idBot)->name;
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
                ->route('bot.messagegroup.list', $this->idBot)
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
        return [];
    }
}
