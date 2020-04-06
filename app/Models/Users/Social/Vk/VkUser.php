<?php

namespace App\Models\Users\Social\Vk;

use App\Models\Users\Social\ParamsTrait;
use App\Models\Users\Social\RoleTrait;
use App\Models\Users\Social\StatusTrait;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use App\Models\Region;

class VkUser extends Model
{
    use AsSource, Filterable, Attachable;
    use RoleTrait, StatusTrait, ParamsTrait;

    protected $guarded = [];

    protected $casts = [
        'params' => 'array'
    ];

    public function addInvite(int $invite): VkUser
    {
        $this->referral = $invite;
        $this->save();
        return $this;
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function invite()
    {
        return $this->belongsTo(self::class, 'referral', 'vk_id');
    }
}
