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
            TD::set('name', 'Название')
                ->render(function (MessageGroup $messagegroup) {
                    return Link::make($messagegroup->name)
                        ->route('bot.messagegroup.edit', [$messagegroup->bot_id, $messagegroup->id]);
                }),
            TD::set('name', 'Сообщения')
                ->render(
                    function (MessageGroup $messagegroup)
                    {
                        return $messagegroup->messages;
                    }
                ),

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
