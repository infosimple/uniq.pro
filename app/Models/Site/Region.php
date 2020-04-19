<?php

namespace App\Models\Site;

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
