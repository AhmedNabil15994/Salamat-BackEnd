<?php

namespace Modules\Operator\Entities;

use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Operator extends Authenticatable
{
    use Notifiable , ScopesTrait , HasApiTokens;

    use EntrustUserTrait {
      restore as private restoreA;
    }
    use SoftDeletes {
      restore as private restoreB;
    }

    protected $table = 'users';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
      'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image' , 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function shift()
    {
        return $this->morphOne(\Modules\Availability\Entities\Shift::class , 'shiftable');
    }

    public function offDays()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffDays::class , 'dayable_off');
    }

    public function offCustomDates()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffCustomDate::class , 'customable_off');
    }

    public function offDates()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffDates::class , 'dateable_off');
    }

    public function offTimes()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffTimes::class , 'timeable_off');
    }

    public function clinic()
    {
        return $this->hasOne('Modules\Clinic\Entities\ClinicOperator');
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    public function upcomingOrders()
    {
        return $this->orders()->where('order_status_id',2)->where('date','>=',date('Y-m-d'));
    }

    // public function clinic()
    // {
    //     return $this->belongsToMany('Modules\Clinic\Entities\Clinic','clinic_operators','clinic_id','operator_id');
    // }

    // public function unavailableDays()
    // {
    //     return $this->morphMany(\Modules\Availability\Entities\OffDays::class , 'dayable_off');
    // }
    //
    // public function unavailableCustomDate()
    // {
    //     return $this->morphMany(\Modules\Availability\Entities\OffCustomDate::class , 'customable_off');
    // }
    //
    // public function unavailableDates()
    // {
    //     return $this->morphMany(\Modules\Availability\Entities\OffDates::class , 'dateable_off');
    // }
    //
    // public function unavailableTimes()
    // {
    //     return $this->morphMany(\Modules\Availability\Entities\OffTimes::class , 'timeable_off');
    // }
}
