<?php

namespace Modules\Point\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class UserPoint extends Model
{
    use ScopesTrait;

  	protected $fillable = [ 'status' , 'user_id' , 'points' , 'clinic_id' ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(\Modules\Clinic\Entities\Clinic::class);
    }
}
