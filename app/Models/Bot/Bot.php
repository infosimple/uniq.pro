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

    public $timestamps = false;

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
    public function eventMessage()
    {
        return $this->hasMany(EventMessage::class);
    }

    public function delete()
    {
        $this->button()->delete();
        $this->keyboard()->delete();
        $this->message()->delete();
        $this->messagegroup()->delete();
        $this->eventMessage()->delete();
        return parent::delete();
    }

    public function scopeGetBotSocial($query, $soc)
    {
        return $query->where('soc', $soc)->with(['eventMessage', 'message', 'keyboard'])->firstOrFail();
    }
    static public function getConfig($soc, $config){
        return static::where('soc', $soc)->first()->config[$config];
    }
}
