<?php

namespace Modules\Blog\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Blog extends Model implements TranslatableContract
{
  	use Translatable , ScopesTrait , SoftDeletes;

    protected $with               = [ 'translations' ];
  	protected $fillable 		  = [ 'status','image' , 'video' , 'blogable_id' , 'blogable_type'];
  	public $translatedAttributes  = ['description' , 'title' , 'slug'];
    public $translationModel 	  = BlogTranslation::class;

    public function blogable()
    {
        return $this->morphTo();
    }

    public function doctors()
    {
        return $this->belongsTo(\Modules\Doctor\Entities\Doctor::class, 'blogable_id')
                    ->whereBlogableType(\Modules\Doctor\Entities\Doctor::class);
    }
    public function clinics()
    {
        return $this->belongsTo(\Modules\Clinic\Entities\Clinic::class, 'blogable_id')
                    ->whereBlogableType(\Modules\Clinic\Entities\Clinic::class);
    }
}
