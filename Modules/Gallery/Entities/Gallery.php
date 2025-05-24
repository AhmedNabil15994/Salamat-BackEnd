<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Clinic\Entities\Clinic;

class Gallery extends Model
{
  	protected $fillable = [
        'image' , 'galleryable_id' , 'galleryable_type'
    ];

    public function galleryable()
    {
        return $this->morphTo();
    }

    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'galleryable_id')->whereGalleryableType(Clinic::class);
    }
}
