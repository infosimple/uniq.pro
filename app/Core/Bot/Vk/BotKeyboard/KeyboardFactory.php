<?php
namespace App\Core\Bot\Vk\BotKeyboard;

class KeyboardFactory
{

    public static function createKeyboard(): Keyboard
    {
        return new Keyboard();
    }

}
