<?php

namespace App\Orchid\Layouts\Bot;

use App\Models\Bot\Bot;
use App\Orchid\Screens\Bot\Vk\BotEditScreen;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BotListLayout extends Table
{

    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'bot';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {

        return [
            TD::set('name', 'Название бота')
                ->render(function (Bot $bot) {
                    return Link::make($bot->name)
                        ->route('bot.'.$bot->soc.'.edit', $bot->id);
                }),
            TD::set('soc', 'Социальная сеть')
                ->render(function (Bot $bot) {
                    return '<img src="/img/' . $bot->soc . '.png" style="width: 24px; height: 24px;" />';
                })->align('center'),

            TD::set('', 'Кнопки')
                ->render(function (Bot $bot) {
                    return Link::make($bot->button->count())
                        ->route('bot.button.list', $bot->id);
                }),

            TD::set('', 'Клавиатуры')
                ->render(function (Bot $bot) {
                    return Link::make(85)
                        ->route('bot.keyboard.list', $bot->id);
                }),
            TD::set('', 'Сообщения')
                ->render(function (Bot $bot) {
                    return Link::make(85)
                        ->route('bot.message.list', $bot->id);
                }),
            TD::set('', 'Группы сообщений')
                ->render(function (Bot $bot) {
                    return Link::make(85)
                        ->route('bot.messagegroup.list', $bot->id);
                }),
            TD::set('id', 'Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Bot $bot) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('bot.'.$bot->soc.'.edit', $bot->id)
                                ->icon('icon-pencil'),

                            Button::make(__('Удалить'))
                                ->method('remove')
                                ->confirm(__('Вы уверены, что хотите удалить бота?'))
                                ->parameters([
                                    'id' => $bot->id
                                ])
                                ->icon('icon-trash')
                        ]);
                })

        ];
    }
}
