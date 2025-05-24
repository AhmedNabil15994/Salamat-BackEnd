<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OrderCoupon extends Model
{
    use ScopesTrait;

    protected $fillable = [
      'coupon_id',
      'order_id',
    ];

    public function coupon()
    {
        return $this->belongsTo(\Modules\Coupon\Entities\Coupon::class);
    }
}
