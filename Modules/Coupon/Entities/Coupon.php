<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Coupon extends Model
{
    use ScopesTrait;

  	protected $fillable = ['status' , 'discount' , 'used_times' , 'doctor_id','code' , 'from' , 'to' , 'clinic_id'];

    public function doctor()
    {
        return $this->belongsTo(\Modules\Doctor\Entities\Doctor::class , 'doctor_id');
    }

    public function services()
    {
        return $this->belongsToMany(\Modules\Service\Entities\Service::class , 'coupon_services');
    }

    public function users()
    {
        return $this->belongsToMany(\Modules\User\Entities\User::class , 'coupon_users');
    }
}
