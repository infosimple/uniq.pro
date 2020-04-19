<?php

namespace App\Orchid\Layouts\Bot\KeyBoard;

use App\Models\Bot\KeyBoard;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class KeyBoardListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'key_boards';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {


        return [
            TD::set('title', 'Название')
                ->render(function (KeyBoard $keyboard) {
                    return Link::make($keyboard->title)
                        ->route('bot.keyboard.edit', [$keyboard->bot_id, $keyboard->id]);
                }),
            TD::set('name', 'Вызываемое фраза')
                ->render(function (KeyBoard $keyboard) {
                    return $keyboard->name;
                }),

            TD::set('id', 'Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (KeyBoard $keyboard) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('bot.keyboard.edit', [$keyboard->bot_id, $keyboard->id])
                                ->icon('icon-pencil'),

                            Button::make(__('Удалить'))
                                ->method('remove')
                                ->confirm(__('Вы уверены, что хотите удалить клавиатуру?'))
                                ->parameters([
                                    'id' => $keyboard->id
                                ])
                                ->icon('icon-trash')
                        ]);
                })
        ];
    }
}
