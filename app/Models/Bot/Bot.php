<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Bot extends Model
{
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'name',
        'soc',
        'config',
    ];

    protected $allowedSorts = [
        'name',
        'soc',
    ];

    protected $casts = [
        'config'       => 'array',
    ];

    public function button()
    {
        return $this->hasMany(Button::class);
    }
}
