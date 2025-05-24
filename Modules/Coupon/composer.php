<?php

view()->composer([
  'doctor::dashboard.services.*',
  'service::dashboard.*',
], \Modules\Coupon\ViewComposers\Dashboard\CouponComposer::class);
