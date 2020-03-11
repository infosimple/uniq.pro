<?php

namespace App\Orchid\Screens\Bot\Message;

use App\Models\Bot\Bot;
use App\Models\Bot\Message;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MessageEditScreen extends Screen
{
    public $name = 'Создание сообщения';
    public $description = '';

    /**
     * Получаем id бота
     */
    public $idBot = "";
    /**
     * Проверка на создание или редактирование сообщения
     */
    public $exists = false;

    public function query(Request $request, Message $message): array
    {        $this->exists = $message->exists;

        if($this->exists){
            $this->name = 'Изменение сообщения: ' . $message->name;
        }

        $this->idBot = $request->bot;
        $this->description = Bot::find($this->idBot)->name;
        return [
            'message' => $message
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
                ->route('bot.message.list', $this->idBot)
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
