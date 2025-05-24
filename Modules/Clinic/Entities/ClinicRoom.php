<?php

namespace Modules\Clinic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClinicRoom extends Model
{
    protected $fillable = ['clinic_id'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
