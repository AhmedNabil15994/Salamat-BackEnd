<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceDoctor extends Model
{
    protected $fillable = ['service_id' , 'doctor_id'];
    protected $table    = 'service_doctor';

    public function doctor()
    {
        return $this->belongsTo('Modules\Doctor\Entities\Doctor','doctor_id','id');
    }

    public function service()
    {
        return $this->belongsTo('Modules\Service\Entities\Service','service_id','id');
    }
}
