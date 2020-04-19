<?php


namespace App\Core\Bot\Vk\HandlersCallback;

use App\Core\Bot\Vk\Response\Base\ActionResponse;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Http\Request;

class AbstractHandler
{
    public $user, $request, $params, $button, $msg = null, $img = null;

    public function __construct(VkUser $vkUser, Request $request = null)
    {
        $this->user = $vkUser;
        $this->request = $request;
        $this->params = $this->getParams();
        if ($request) {
            $this->button = $this->getPayload();
            if (!$this->button) {
                $this->msg = $this->getMessageRequest();
                if (!$this->msg) {
                    $this->img = $this->getImage();
                }
            }
        }
    }

    public function chekResponse()
    {
        switch ($this->params['response']) {
            case 'int':
                if (ctype_digit($this->msg)) {
                    return $this->msg;
                };
                return false;
            case 'img':
                if ($this->img) {
                    return $this->img;
                };
                return false;
            case 'text':
                if ($this->msg) {
                    return $this->msg;
                };
                return false;
            default:
                return false;
        }
    }

    private function getPayload()
    {
        if (isset($this->request->object['payload'])) {
            $payload = json_decode($this->request->object['payload'], true);
            if (isset($payload['button'])) {
                return $payload['button'];
            }
            return false;
        }
    }

    private function getParams()
    {
        if ($this->user->params) {
            return $this->user->params;
        }
        return false;
    }

    private function getMessageRequest()
    {
        if (isset($this->request->object['text'])) {
            return $this->request->object['text'];
        }
        return false;
    }

    private function getImage()
    {
        $img = $this->request->object['attachments'];
        if ($img) {
            $rez = collect(json_decode(json_encode($img), true))->collapse()->get('photo');
            $photo = end($rez['sizes']);
            return $photo['url'];
        }
        return false;
    }
}
