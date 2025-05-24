<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    protected $fillable = [ 'description' , 'title' , 'slug' , 'doctor_blog_id' ];
}
