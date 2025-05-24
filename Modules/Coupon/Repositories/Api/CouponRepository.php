<?php

namespace Modules\Coupon\Repositories\Api;

use Modules\Coupon\Entities\Coupon;
use DB;

class CouponRepository
{

    function __construct(Coupon $coupon)
    {
        $this->coupon   = $coupon;
    }

    public function checkCoupon($request)
    {
        $found = false;

        $coupon = $this->coupon
        ->where('code',$request['coupon'])
        ->where('from','<=',date('Y-m-d'))
        ->where('to','>=',date('Y-m-d'))
        ->active()
        ->first();

        if (!empty($coupon) && $coupon->doctor_id != null) {
            $found = ($coupon->doctor_id == $request['doctor_id']) ? true : false;
        }

        if (!empty($coupon) && count($coupon->users) > 0) {
            $found = ($coupon->users->contains(auth()->id())) ? true : false;
        }

        return $found ? $coupon : false;
    }
}
