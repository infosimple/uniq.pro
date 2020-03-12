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
    public function keyboard()
    {
        return $this->hasMany(KeyBoard::class);
    }
    public function message()
    {
        return $this->hasMany(Message::class);
    }
    public function messagegroup()
    {
        return $this->hasMany(MessageGroup::class);
    }

    public function delete()
    {
        $this->button()->delete();
        $this->keyboard()->delete();
        $this->message()->delete();
        $this->messagegroup()->delete();
        return parent::delete();
    }
}
