<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{
    protected $fillable = ['title' , 'slug' , 'description'];
}
