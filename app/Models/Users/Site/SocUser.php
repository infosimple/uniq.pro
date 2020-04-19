<?php

namespace App\Models\Users\Site;

use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Database\Eloquent\Model;

class SocUser extends Model
{
    protected $fillable = [
        'vk_user_id',
        'telegram_user_id',
        'watsup_user_id'
    ];

        public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'soc_id');
    }

    public function vkUser()
    {
        return $this->belongsTo(VkUser::class, 'vk_user_id');
    }
}
