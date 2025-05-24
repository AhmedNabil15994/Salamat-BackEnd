<?php

namespace Modules\Specialty\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Specialty extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with               = [ 'translations' ];
  	protected $fillable 		  = [ 'status' , 'image' ];

  	public $translatedAttributes  = [ 'title' , 'slug' , 'seo_description' , 'seo_keywords' ];
    public $translationModel 	  = SpecialtyTranslation::class;

    public function doctors()
    {
        return $this->belongsToMany('Modules\Doctor\Entities\Doctor','doctor_specialties','specialty_id','doctor_id');
    }

}
