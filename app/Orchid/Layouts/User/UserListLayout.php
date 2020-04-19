<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\Users\Site\User;
use App\Models\Users\Social\IStatuses;
use App\Models\Users\Social\Vk\VkUser;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'users';

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            TD::set('name', __('Name'))
                ->sort()
                ->canHide()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    // Please use Blade templates.
                    // This will be a simple example: view('path', ['user' => $user])
                    $avatar = e($user->getAvatar());
                    $route = route('platform.systems.users.edit', $user->id);
                    switch ($user->roles->slug){
                        case 'moderator':
                            $style = 'bg-warning text-black';
                            break;
                        case 'admin':
                            $style = 'bg-primary text-white';
                            break;
                        case 'user':
                            $style = 'bg-secondary text-white';
                            break;
                        case 'client':
                            $style = 'bg-success text-white';
                            break;
                        case 'disabled':
                            $style = 'bg-danger text-white';
                            break;
                    }

                    return "<a href='{$route}'>
                                <div class='d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center'>
                                    <span class='thumb-xs avatar m-r-xs d-none d-md-inline-block'>
                                      <img src='{$avatar}' class='bg-light'>
                                    </span>
                                    <div class='ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0'>
                                      <p class='mb-0'>{$user->name}</p>
                                      <small class='p-0 mb-2 rounded {$style}'>{$user->roles->name}</small>
                                    </div>
                                </div>
                            </a>";
                }),

            TD::set('status', 'Статус')
                ->render(function (User $user) {
                    switch ($user->status){
                        case IStatuses::NOT_ACTIVATE:
                            return '<span>Не активирован</span>';
                        case IStatuses::MODERATION:
                            return '<span class="p-1 mb-2 bg-warning rounded text-dark">На модерации</span>';
                        case IStatuses::ACTIVATE:
                            return '<span class="p-1 mb-2 bg-success rounded text-white">Активирован</span>';
                        case IStatuses::DISABLED:
                            return '<span class="p-1 mb-2 bg-danger rounded text-white">Отключен</span>';
                        case IStatuses::BUSY:
                            return '<span class="p-1 mb-2 bg-dark rounded text-white">Занят</span>';
                        case IStatuses::FREE:
                            return '<span class="p-1 mb-2 bg-info rounded text-white">Свободен</span>';
                    }
                }),

            TD::set('email', __('Email'))
                ->sort()
                ->canHide()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    return ModalToggle::make($user->email)
                        ->modal('oneAsyncModal')
                        ->modalTitle($user->getNameTitle())
                        ->method('saveUser')
                        ->asyncParameters($user->id);
                }),

            TD::set('last_login', __('Последний раз заходил'))->render(function (User $user){
                if($user->online()){
                    return '<span class="p-1 mb-2 bg-success rounded text-white">Online</span>';
                }
                   return $user->last_login ?  $user->last_login->diffForHumans() : '<span class="icon-ban"></span>';
            })
                ->sort(),

            TD::set('id', 'ID')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (User $user) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.systems.users.edit', $user->id)
                                ->icon('icon-pencil'),

                            Button::make(__('Delete'))
                                ->method('remove')
                                ->confirm(__('Are you sure you want to delete the user?'))
                                ->parameters([
                                    'id' => $user->id,
                                ])
                                ->icon('icon-trash'),
                        ]);
                }),
        ];
    }
}
