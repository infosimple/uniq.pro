<?php

namespace App\Orchid\Layouts\Bot\Vk\Users;

use App\Models\Users\Social\Vk\VkUser;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VkUserListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'vkuser';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::set('info', 'Инфа')
                ->render(function (VkUser $user) {
                    $avatar = e($user->photo_50);
                    $name = e($user->name);
                    $vk_id = e($user->vk_id);
                    $route = route('user.vk.edit', $user->id);

                    return "<a href='{$route}'>
                                <div class='d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center'>
                                    <span class='thumb-xs avatar m-r-xs d-none d-md-inline-block'>
                                      <img src='{$avatar}' class='bg-light'>
                                    </span>
                                    <div class='ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0'>
                                      <p class='mb-0'>{$name}</p>
                                      <small class='text-xs text-muted'>{$vk_id}</small>
                                    </div>
                                </div>
                            </a>";
                }),
            TD::set('region', 'Регион')
                ->render(function (VkUser $user) {
                    if($user->region){
                        return $user->region->name;
                    }else{
                        return '<span class="icon-ban"></span>';
                    }
                }),
            TD::set('referral', 'Пригласивший')
                ->render(function (VkUser $user) {
                    if ($user->invite){
                        return Link::make($user->invite->name)
                            ->route('user.vk.edit', [$user->invite->id]);
                    }
                    else{
                        return '<span class="icon-ban"></span>';
                    }
                }),
            TD::set('score', 'Счет')
                ->render(function (VkUser $user) {
                        return $user->points;
                }),
            TD::set('status', 'Статус')
                ->render(function (VkUser $user) {
                    switch ($user->status){
                        case 0:
                            return '<span>Неизвестный</span>';
                        case 1:
                            return '<span class="p-1 mb-2 bg-warning rounded text-dark">Модерация</span>';
                        case 2:
                            return '<span class="p-1 mb-2 bg-secondary rounded text-white">Приглашен</span>';
                        case 3:
                            return '<span class="p-1 mb-2 bg-success rounded text-white">Активирован</span>';
                        case 4:
                            return '<span class="p-1 mb-2 bg-primary rounded text-white">Занят</span>';
                        case 5:
                            return '<span class="p-1 mb-2 bg-danger rounded text-white">Не прошел модерацию</span>';
                    }
                }),
            TD::set('last_run_at', 'Работал')
        ];
    }
}
