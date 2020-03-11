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
        'messages',
        'bot_id'
    ];
}
