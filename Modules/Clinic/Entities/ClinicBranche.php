<?php

namespace Modules\Clinic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClinicBranche extends Model
{
    protected $fillable = [
        'clinic_id' , 'state_id' , 'phone_number' , 'another_phone_number' , 'status' , 'building' , 'block' , 'street' , 'address_details' , 'lat' , 'lang'
    ];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
