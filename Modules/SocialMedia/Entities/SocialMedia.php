<?php

namespace Modules\SocialMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Clinic\Entities\Clinic;

class SocialMedia extends Model
{
    protected $table = 'social_medias';

  	protected $fillable = [
        'name' , 'link' , 'socialable_id' , 'socialable_type'
    ];

    public function socialable()
    {
        return $this->morphTo();
    }

    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'socialable_id')->whereSocialableType(Clinic::class);
    }

}
