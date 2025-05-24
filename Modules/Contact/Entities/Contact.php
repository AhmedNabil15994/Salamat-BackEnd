<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Clinic\Entities\Clinic;

class Contact extends Model
{
  	protected $fillable = ['mobile' , 'contactable_id' , 'contactable_type'];

    public function contactable()
    {
        return $this->morphTo();
    }

    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'contactable_id')->whereContactableType(Clinic::class);
    }
}
