<?php

namespace App\Core\Bot\Vk\Response\Base;

use App\Models\Bot\Bot;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Http\Request;
use VK\Client\VKApiClient;

abstract class AbstractResponse
{

    public $vkApiClient;
    public $request;
    public $user;
    public $bot;

    public function __construct(
        VkUser $vkUser,
        Request $request = null
    )
    {
        $this->user = $vkUser;
        $this->request = $request;
        $this->bot = Bot::getBotSocial('vk');
        $this->vkApiClient = new VKApiClient($this->bot->config['version']);
    }
}
