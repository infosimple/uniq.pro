<?php

namespace App\Models\Users\Site;

use App\Models\Users\Social\IStatuses;
use App\Models\Users\Social\Vk\VkUser;
use App\Models\Users\Social\Telegram\TelegramUser;
use App\Models\Users\Social\Watsup\WatsupUser;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    public function vkAccount()
    {
        return $this->hasOneThrough(VkUser::class, SocUser::class, 'vk_user_id', 'id', 'soc_id', 'id');
    }

    public function telegramAccount()
    {
        return $this->hasOneThrough(TelegramUser::class, SocUser::class, 'telegram_user_id', 'id', 'soc_id', 'id');
    }

    public function watsupAccount()
    {
        return $this->hasOneThrough(WatsupUser::class, SocUser::class, 'watsup_user_id', 'id', 'soc_id', 'id');
    }

    public function socAccount()
    {
        return $this->belongsTo(SocUser::class, 'soc_id');
    }

    public function scopeModerators($query)
    {
        $moderators = $query->with(['roles', 'vkAccount', 'telegramAccount', 'watsupAccount'])->get();
        return $moderators->where(['roles.slug' => 'moderator', 'status' => IStatuses::FREE])->all();
    }

}
