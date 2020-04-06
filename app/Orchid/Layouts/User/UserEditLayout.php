<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\Users\Social\Vk\VkUser;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
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

            Select::make('user.vk_user_id')
                ->fromModel(VkUser::class, 'name')
                ->title('Аккаунт в VK')
                ->empty(),
        ];
    }
}
