<?php

namespace App\Models\Bot;

use App\Models\Bot\MessageEdit;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Message extends Model
{
    use AsSource, Filterable, MessageEdit;

    public $timestamps = false;

    protected $guarded = [];

    protected $allowedFilters = [
        'group_id'
    ];
    protected $allowedSorts = [
        'id',
        'order'
    ];

    public function keyboard()
    {
        return $this->hasOne(KeyBoard::class, 'id', 'keyboard_id');
    }
    public function group()
    {
        return $this->belongsTo(MessageGroup::class, 'group_id');
    }

}
