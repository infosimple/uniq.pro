<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class MessageGroup extends Model
{
    use AsSource, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'bot_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'group_id')->where('bot_id', $this->bot_id)->get();
    }
    public function eventMessages()
    {
        return $this->hasMany(EventMessage::class, 'group_id')->where('bot_id', $this->bot_id)->get();
    }
}
