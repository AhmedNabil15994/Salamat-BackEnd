<?php

namespace Modules\Specialty\Entities;

use Illuminate\Database\Eloquent\Model;

class SpecialtyTranslation extends Model
{
    protected $fillable = [ 'title' , 'slug' , 'seo_description' , 'seo_keywords' , 'specialty_id'];
}
