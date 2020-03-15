<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Message extends Model
{
    use AsSource, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'text',
        'keyboard_id',
        'bot_id',
        'method',
        'method_text'
    ];

    protected $casts = [
        'response_type' => 'array',
    ];


    public function keyboard()
    {
        return $this->hasOne(KeyBoard::class, 'id', 'keyboard_id');
    }

}
