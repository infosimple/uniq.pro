<?php


namespace App\Core\Bot\Vk\Response\User;

use App\Models\Users\Social\IRoles;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Support\Carbon;

class UserResponse
{
    public $user;
    public $bot;
    public $vkApiClient;

    public function __construct(VkUser $user)
    {
        $this->user = $user;
        $this->bot = $user->bot;
        $this->vkApiClient = $user->vkApiClient;
    }

    public function askInvite($response)
    {
        $inviterUser = VkUser::where(['vk_id' => $response, 'role' => IRoles::CLICKER])->first();
        if ($inviterUser) {
            if ($this->chekFriend($inviterUser->vk_id)) {
                return $this->user->addInvite($inviterUser)->sendEvent('askRegion');
            }
        }

        return $this->user->sendBadAnswerMsg('askInvite');
    }

    public function askRegion($response)
    {
        $nameAnswer = $this->getNameAnswer();
        if ($nameAnswer) {
            $this->user->addAnswer($nameAnswer, $response);
        }
        $sendEvent = $this->user->sendEvent('askRegion');
        if (!$sendEvent) {
            \Log::debug($this->user->params['answer']);
            return $this->user->moderation()->removeOrder()->removeAnswer()->sendEvent('moderationRegion');
        }
    }

    public function getNameAnswer()
    {
        $event = $this->user->bot->eventMessage
            ->where('name', $this->user->params['event'])
            ->where('order', $this->user->params['order'])
            ->first();
        if (isset($event->name_answer)) {
            return $event->name_answer;
        }
        return false;
    }

    // Проверка дружбы рефера с добавляемым
    public function chekFriend($invite_id)
    {
        // получаем всех друзей
        try {
            $data = $this->vkApiClient->friends()->get($this->bot->config['user_token'], ['user_id' => $invite_id]);
        } catch (\Exception $e) {
            $this->chekFriendRevers($invite_id);
        }
        // ищем нужного друга в массиве
        if (array_search($this->user->vk_id, $data['items']) == NULL) {
            return true;
        }

        return false;
    }

    // Обратная проверка дружбы рефера с добавляемым
    public function chekFriendRevers($invite_id)
    {
        $data = null;
        try {
            $data = $this->vkApiClient->friends()->get($this->bot->config['user_token'], ['user_id' => $this->user->vk_id]);
        } catch (\Exception $e) {
            return false;
        }
        if (array_search($invite_id, $data['items']) == NULL) {
            return true;
        }

        return false;
    }

    // Проверка на давность регистрации (должно быть больше 180 дней)
    public function daysRegister()
    {

        $data = file_get_contents('http://vk.com/foaf.php?id=' . $this->user->vk_id);
        preg_match('/(?<=<ya:created\ dc:date=").*?(?=T)/', $data, $matches);
        $days = Carbon::now()->diffInDays($matches[0]);
        return $days;
    }

    public function method($name, $response = null)
    {
        return $this->$name($response);
    }

//    public function chekRegion()
//    {
//        $img = $this->request->object['attachments'];
//        if ($img) {
//            $rez = collect(json_decode(json_encode($img), true))->collapse()->get('photo');
//            $photo = end($rez['sizes']);
//            $this->user->createParams(['method' => 'moderationRegion']);
//            $this->getMessageMethod('moderationRegion');
//            $this->user->onModeration();
//            (new Moderation)->addTask(['type' => 'region', 'soc' => 'vk', 'user' => $this->user->id, 'imgRegionGoogle' => $photo['url']], 5);
//        } else {
//            $this->getMessageMethod('addRegion', true);
//        }
//    }
}
