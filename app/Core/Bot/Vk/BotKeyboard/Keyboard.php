<?php
namespace App\Core\Bot\Vk\BotKeyboard;

use Illuminate\Database\Eloquent\Model;

class Keyboard extends Model
{
    protected $table = 'key_boards';
    private $keyboard = [];
    private $oneTime = false;

    public function addRow(array $buttonRow): self
    {
        $this->keyboard['buttons'][] = $buttonRow;

        return $this;
    }

    public function setOneTime(bool $value): self
    {
        $this->oneTime = $value;

        return $this;
    }

    public function getKeyboardJson(): string
    {
        return json_encode($this->keyboard, JSON_UNESCAPED_UNICODE);
    }
}
