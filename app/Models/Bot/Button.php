<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Button extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'name',
        'color',
        'command',
        'methods',
        'bot_id',
    ];

    public $timestamps = false;

    protected $casts = [
        'methods'       => 'array',
    ];

}
