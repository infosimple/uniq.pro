<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\Users\Social\IStatuses;
use App\Models\Users\Social\Vk\VkUser;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Select::make('user.roles_id')
                ->fromModel(Role::class, 'name')
                ->required()
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
            Select::make('user.status')
                ->title('Статус пользователя')
                ->required()
                ->options([
                    IStatuses::NOT_ACTIVATE => 'Не активирован',
                    IStatuses::MODERATION => 'На модерации',
                    IStatuses::ACTIVATE => 'Активирован',
                    IStatuses::DISABLED => 'Отключен',
                    IStatuses::FREE => 'Свободен',
                    IStatuses::BUSY => 'Занят'
                ]),
            Relation::make('soc.vk_user_id')
                ->fromModel(VkUser::class, 'vk_id')
                ->displayAppend('name')
                ->title('Аккаунт в VK'),
        ];
    }
}
