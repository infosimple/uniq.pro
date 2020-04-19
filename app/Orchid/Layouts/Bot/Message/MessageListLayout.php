<?php

namespace App\Orchid\Layouts\Bot\Message;

use App\Models\Bot\Message;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MessageListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'message';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::set('title', 'Название')
                ->render(function (Message $message) {
                    return Link::make($message->title)
                        ->route('bot.message.edit', [$message->bot_id, $message->id]);
                }),
            TD::set('name', 'Вызываемая фраза')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Message $message) {
                        return $message->name;
                }),
            TD::set('group_id', 'Группа')
                ->filter(TD::FILTER_TEXT)
                ->render(function (Message $message) {
                    if ($message->group){
                        return Link::make($message->group->name)
                            ->route('bot.message.list', [$message->bot_id, 'filter[group_id]' => $message->group->id]);
                    }else{
                        return '<span class="icon-ban"></span>';
                    }
                }),
            TD::set('keyboard', 'Клавиатура')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Message $message) {
                    if ($message->keyboard){
                        return $message->keyboard->name;
                    }else{
                        return '<span class="icon-ban"></span>';
                    }
                }),
            TD::set('text', 'Текст сообщения')
                ->render(function (Message $message) {
                    return mb_substr($message->text, 0, 60);
                }),

            TD::set('id', 'Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Message $message) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('bot.message.edit', [$message->bot_id, $message->id])
                                ->icon('icon-pencil'),

                            Button::make(__('Удалить'))
                                ->method('remove')
                                ->confirm(__('Вы уверены, что хотите удалить сообщение?'))
                                ->parameters([
                                    'id' => $message->id
                                ])
                                ->icon('icon-trash')
                        ]);
                })
        ];
    }
}
