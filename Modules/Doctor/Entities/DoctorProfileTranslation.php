<?php

namespace Modules\Doctor\Entities;

use Illuminate\Database\Eloquent\Model;

class DoctorProfileTranslation extends Model
{
    protected $fillable = ['about' , 'job_title' , 'name', 'open_time_message'];
}
