<?php

namespace Modules\Doctor\Entities;

use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
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
        'name', 'email', 'password', 'mobile' , 'image','sorting_doctor' , 'status'
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

    public function profile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function contacts()
    {
        return $this->morphMany(\Modules\Contact\Entities\Contact::class, 'contactable');
    }

    public function gallery()
    {
        return $this->morphMany(\Modules\Gallery\Entities\Gallery::class, 'galleryable');
    }

    public function socialMedia()
    {
        return $this->morphMany(\Modules\SocialMedia\Entities\SocialMedia::class, 'socialable');
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

    public function doctorSocialMediaByName($name)
    {
        return $this->socialMedia()->where('name',$name)->first();
    }

    public function specialties()
    {
        return $this->belongsToMany(
            'Modules\Specialty\Entities\Specialty','doctor_specialties','doctor_id','specialty_id'
        );
    }

    public function services()
    {
      return $this->belongsToMany('Modules\Service\Entities\Service','service_doctor','doctor_id','service_id');
    }

    public function clinic()
    {
        return $this->hasOne('Modules\Clinic\Entities\ClinicDoctor');
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    public function upcomingOrders()
    {
        return $this->orders()->whereHas('service', function($query){
            $query->where('ignore_doctor',false);
        })->where('order_status_id',2)->where('date','>=',date('Y-m-d'));
    }

    public function blogs()
    {
        return $this->morphMany(\Modules\Blog\Entities\Blog::class, 'blogable');
    }

    public function rates()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderRate::class);
    }
}
