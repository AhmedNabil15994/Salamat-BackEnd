<?php

namespace Modules\Category\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Category extends Model
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with                 = ['translations'];
  	protected $fillable 		    = ['status' , 'image' , 'clinic_id' , 'sorting'];
  	public $translatedAttributes 	= ['description' , 'title' , 'slug'];
    public $translationModel 		= CategoryTranslation::class;

    public function services()
    {
        return $this->hasMany(\Modules\Service\Entities\Service::class);
    }

    public function clinic()
    {
        return $this->belongsTo(\Modules\Clinic\Entities\Clinic::class , 'clinic_id');
    }

    public function doctor()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class , 'user_id');
    }
}
