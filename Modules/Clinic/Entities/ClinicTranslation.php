<?php

namespace Modules\Clinic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClinicTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' , 'seo_description' , 'seo_keywords', 'open_time_message'];
}
