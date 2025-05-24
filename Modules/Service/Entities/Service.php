<?php

namespace Modules\Service\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Service extends Model
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with         = ['translations'];
  	protected $fillable 	= [
      'status','image','hidden','is_consultation','price','category_id' , 'clinic_id', 'service_take_time','ignore_doctor'
    ];

  	public $translatedAttributes 	= [ 'description' , 'title' , 'slug' ];
    public $translationModel 	    = ServiceTranslation::class;

    public function doctor()
    {
        return $this->hasOne(ServiceDoctor::class);
    }

    public function rooms()
    {
        return $this->belongsToMany('Modules\Room\Entities\Room','service_rooms','service_id','room_id');
    }

    public function operators()
    {
        return $this->belongsToMany('Modules\Operator\Entities\Operator','service_operators','service_id','operator_id');
    }

    public function clinic()
    {
        return $this->belongsTo('Modules\Clinic\Entities\Clinic','clinic_id','id')->where('deleted_at',null);
    }

    public function points()
    {
        return $this->hasOne('Modules\Point\Entities\Point');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Category\Entities\Category');
    }
}
