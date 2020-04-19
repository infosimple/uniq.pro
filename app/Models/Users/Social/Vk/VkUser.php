<?php

namespace App\Models\Users\Social\Vk;

use App\Core\Bot\Vk\Response\Base\ActionResponse;
use App\Models\Bot\Bot;
use App\Models\Users\Social\ParamsTrait;
use App\Models\Users\Social\RoleTrait;
use App\Models\Users\Social\StatusTrait;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use App\Models\Site\Region;
use VK\Client\VKApiClient;

class VkUser extends Model
{
    use AsSource, Filterable, Attachable;
    use RoleTrait, StatusTrait, ParamsTrait;
    use ActionResponse;


    protected $guarded = [];

    protected $appends = ['name'];

    protected $casts = [
        'params' => 'array'
    ];

    public function addInvite(VkUser $user)
    {
        $this->invite()
            ->associate($user)
            ->save();
        return $this;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    private function getVkUserData($vk_id)
    {
        $bot = Bot::getBotSocial('vk');
        $vkApiClient = new VKApiClient($bot->config['version']);

        $params = [
            'user_id' => $vk_id,
            'fields' => 'photo_50,screen_name'
        ];
        $data = $vkApiClient->users()->get($bot->config['vk_key'], $params);
        $data = json_decode(json_encode($data), true);
        $data[0]['vk_id'] = $data[0]['id'];
        unset($data[0]['id'], $data[0]['screen_name']);
        return $data[0];
    }

    public function addById($vk_id)
    {
        return $this->create($this->getVkUserData($vk_id));
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function invite()
    {
        return $this->belongsTo(self::class, 'referral');
    }
}
