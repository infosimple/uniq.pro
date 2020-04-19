<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class KeyBoard extends Model
{
    use AsSource, Filterable;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'buttons'       => 'array',
    ];
}
