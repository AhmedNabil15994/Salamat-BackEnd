<?php

namespace Modules\Coupon\ViewComposers\Dashboard;

use Modules\Coupon\Repositories\Dashboard\CouponRepository as Coupon;
use Illuminate\View\View;
use Cache;

class CouponComposer
{
    public $coupons = [];

    public function __construct(Coupon $coupon)
    {
        $this->coupons =  $coupon->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('coupons' , $this->coupons);
    }
}
