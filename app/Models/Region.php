<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Region extends Model
{
    use AsSource, Filterable, Attachable;
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;

}
