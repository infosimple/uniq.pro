<?php
namespace App\Core\Bot\Vk\BotKeyboard;

class ButtonRowFactory
{

    public static function createRow(): ButtonRow
    {
        return new ButtonRow();
    }

}
