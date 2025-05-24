<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OrderRate extends Model
{
    use ScopesTrait;

    protected $fillable = [
        'clinic_id',
        'doctor_id',
        'order_id',
        'user_id',
        'rate',
    ];
}
