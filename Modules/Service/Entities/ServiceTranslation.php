<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' , 'seo_description' , 'seo_keywords'];
}
