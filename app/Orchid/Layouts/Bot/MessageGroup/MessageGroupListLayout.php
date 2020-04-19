<?php

namespace App\Orchid\Layouts\Bot\MessageGroup;

use App\Models\Bot\Message;
use App\Models\Bot\MessageGroup;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

class MessageGroupListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'messagegroup';
    protected $query = '';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::set('id', 'ID'),

            TD::set('name', 'Название')
                ->render(function (MessageGroup $messagegroup) {
                    return Link::make($messagegroup->name)
                        ->route('bot.messagegroup.edit', [$messagegroup->bot_id, $messagegroup->id]);
                }),

            TD::set('messages', 'Количество сообщений')
                ->render(function (MessageGroup $messagegroup) {
                    return Link::make($messagegroup->messages()->count())
                        ->route('bot.message.list', [$messagegroup->bot_id, 'filter[group_id]' => $messagegroup->id]);
                }),

            TD::set('messages', 'Количество событийных сообщений')
                ->render(function (MessageGroup $messagegroup) {
                    return Link::make($messagegroup->eventMessages()->count())
                        ->route('bot.eventMessage.list', [$messagegroup->bot_id, 'filter[group_id]' => $messagegroup->id]);
                }),

            TD::set('id', 'Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (MessageGroup $messagegroup) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('bot.messagegroup.edit', [$messagegroup->bot_id, $messagegroup->id])
                                ->icon('icon-pencil'),

                            Button::make(__('Удалить'))
                                ->method('remove')
                                ->confirm(__('Вы уверены, что хотите удалить сообщение?'))
                                ->parameters([
                                    'id' => $messagegroup->id
                                ])
                                ->icon('icon-trash')
                        ]);
                })


        ];
    }
}
