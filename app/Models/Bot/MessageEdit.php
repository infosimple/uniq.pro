<?php


namespace App\Models\Bot;

use App\Core\Bot\Vk\BotKeyboard\Keyboard;
use App\Models\Users\Social\Vk\VkUser;

trait MessageEdit
{
    public function setKeyBoard($nameKeyBoard)
    {
        $keyboard = $this->getKeyBoard($nameKeyBoard);
        $this->keyboard_id = $keyboard->id;
        $this->load('keyboard');
        return $this;
    }

    public function setMessage($text)
    {
        $this->text = $text;
        return $this;
    }

    public function addParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->text = str_replace('$' . $key, $value, $this->text);
        }
        return $this;
    }

    public function send(VkUser $user){
        $user->send($this);
        if(get_class($this) == 'EventMessage'){
            $user->addEvent($this->name);
        }
        return true;
    }

    private function getKeyBoard($nameKeyBoard)
    {
        $keyboard = Keyboard::where('name', $nameKeyBoard)->first();
        if (!$keyboard) {
            return false;
        }
        return $keyboard;
    }
}
