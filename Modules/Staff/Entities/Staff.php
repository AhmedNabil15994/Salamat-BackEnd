<?php

namespace Modules\Staff\Entities;

use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use Notifiable , ScopesTrait , HasApiTokens;

    use EntrustUserTrait {
      restore as private restoreA;
    }

    use SoftDeletes {
      restore as private restoreB;
    }

    protected $table = 'users';

    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function clinic()
    {
        return $this->hasOne('Modules\Clinic\Entities\ClinicStaff');
    }

}
