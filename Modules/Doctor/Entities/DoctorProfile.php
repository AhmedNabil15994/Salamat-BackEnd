<?php

namespace Modules\Doctor\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class DoctorProfile extends Model implements TranslatableContract
{
    use Translatable ;
    use ScopesTrait;

    protected $table              = 'doctor_profile';
    protected $with               = ['translations'];

    protected $fillable = [
      'status' ,
      'doctor_id',
    ];

    public $translatedAttributes    = [ 'about' , 'job_title' , 'name', 'open_time_message'];

    public $translationModel        = DoctorProfileTranslation::class;
}
