<?php

namespace App\Orchid\Layouts\Bot\Button;


use App\Models\Bot\Bot;
use App\Models\Bot\Button;
use Orchid\Screen\Actions\Button as OrchidButton;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;


class ButtonListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'button';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::set('name', 'Название')
                ->render(function (Button $button) {
                    return Link::make($button->name)
                        ->route('bot.button.edit', [$button->bot_id, $button->id]);
                }),
            TD::set('color', 'Цвет')
                ->render(function (Button $button) {
                    switch ($button->color) {
                        case 'negative' :
                            return "<span class='text-danger'>Красный</span>";
                        case 'secondary' :
                            return 'Без цвета';
                        case 'primary' :
                            return "<span class='text-info'>Синий</span>";
                        case 'positive' :
                            return "<span class='text-success'>Зеленый</span>";
                        default:
                            return '';
                    }
                }),
            TD::set('command', 'Команда')
                ->render(function (Button $button) {
                    return $button->command;
                }),
            TD::set('methods', 'Методы')
                ->render(function (Button $button) {
                    return collect($button->methods)->implode(', ');
                }),
            TD::set('id', 'Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Button $button) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('bot.button.edit', [$button->bot_id, $button->id])
                                ->icon('icon-pencil'),

                            OrchidButton::make(__('Удалить'))
                                ->method('remove')
                                ->confirm(__('Вы уверены, что хотите удалить кнопку?'))
                                ->parameters([
                                    'id' => $button->id
                                ])
                                ->icon('icon-trash')
                        ]);
                })
        ];
    }
}
