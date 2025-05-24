<?php

namespace Modules\Clinic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClinicStaff extends Model
{
    protected $fillable = ['clinic_id'];

    protected $table    = 'clinic_staffs';
    
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
