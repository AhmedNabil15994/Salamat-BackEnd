<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Offer extends Model
{
    use ScopesTrait , Translatable , SoftDeletes;

    protected $with                 = ['translations'];
  	protected $fillable             = ['status' , 'price' , 'clinic_id' , 'image'];
  	public $translatedAttributes 	= ['description' , 'title' , 'slug'];
    public $translationModel 		= OfferTranslation::class;

    public function clinic()
    {
        return $this->belongsTo(\Modules\Clinic\Entities\Clinic::class , 'clinic_id');
    }

    public function services()
    {
        return $this->belongsToMany(\Modules\Service\Entities\Service::class , 'offer_services');
    }
}
