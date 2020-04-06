<?php

namespace App\Orchid\Screens\Bot\Vk\Users;

use App\Models\Users\Social\Vk\VkUser;
use App\Orchid\Layouts\Bot\Vk\Users\VkUserListLayout;
use Orchid\Screen\Screen;

class VkUserListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список пользователей ВК';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'vkuser' => VkUser::with('region', 'invite')->paginate(25)
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            VkUserListLayout::class
        ];
    }
}
