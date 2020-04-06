<?php
namespace App\Core\Bot\Vk\BotKeyboard;

class Button
{

    public static function create(array $payload, string $label, string $colorType): array
    {
    $button['action']['type'] = 'text';
    $button['action']['payload'] = json_encode($payload,JSON_UNESCAPED_UNICODE);
    $button['action']['label'] = $label;
    $button['color']= $colorType;
    return $button;
    }
}
