<?php


namespace App\Core\Bot\Vk\HandlersCallback;

use App\Core\Bot\Vk\Response\User\UserResponse;
use App\Models\Bot\Bot;
use App\Models\Bot\Button;
use App\Models\Users\Social\IStatuses;
use App\Models\Users\Social\Vk\VkAllUser;

class UserHandler extends AbstractHandler
{

    public function handle()
    {
        switch ($this->user->status) {
            case IStatuses::NOT_ACTIVATE:
                return $this->distributor();
            case IStatuses::MODERATION:
                return $this->moderate();
            case IStatuses::DISABLED:
                break;
        }
    }

    private function distributor()
    {
        $response = null;

        if ($this->button) {
            return $this->payload();
        }

        if (isset($this->params['response'])) {
            $response = $this->chekResponse();
            if (!$response) {
                return $this->user->sendBadAnswerMsg($this->params['event']);
            }
        }

        if (isset($this->params['event'])) {
            return (new UserResponse($this->user))->method($this->params['event'], $response);
        }

        if (!$this->params) {
            $this->chekUser();
        }
    }

    private function payload()
    {
        $button = Button::where('command', $this->button)->first();
        foreach ($button->methods as $method) {
            if (preg_match('/(?<=message:).*/', $method, $message)) {
                $this->user->sendMessage($message[0]);
            }

            if (preg_match('/(?<=event:).*/', $method, $name)) {
                $order = null;
                if ($name[0] == 'this') {
                    $name[0] = $this->params['event'];
                    if (isset($this->params['order'])){
                        $order = $this->params['order'];
                    }
                }
                $this->user->sendEvent($name[0], $order);
            }
        }
    }

    private function chekUser()
    {
        $chekId = VkAllUser::where(['id' => $this->user->vk_id, 'status' => 1])->first();

        if ($chekId) {
            $chekId->delete();
            $this->user->sendEvent('askRegion');
        } else {
            $bot = Bot::getBotSocial('vk')->config;
            $daysLive = (new UserResponse($this->user))->daysRegister();
            if ($daysLive > $bot['vk_days']) {
                if ($bot['invite']) {
                    $this->user->sendEvent('askInvite');
                } else {
                    $this->user->sendEvent('askRegion');
                }
            } else {
                $this->user->disabled()->addComment("Дней с регистрации: $daysLive")->sendMessage('notModerationInvite');
            }
        }
    }

    private function moderate()
    {
        if (isset($this->params['event'])) {
            return $this->user->sendModerateMsg($this->params['event']);
        }
    }
}

































