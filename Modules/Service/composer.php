<?php

view()->composer([
    'offer::dashboard.*',
    'coupon::dashboard.*',
    'order::dashboard.orders.*',
], \Modules\Service\ViewComposers\Dashboard\ServiceComposer::class);


view()->composer([
    'offer::clinic.*',
    'order::clinic.orders.*',
    'coupon::clinic.*',
], \Modules\Service\ViewComposers\Clinic\ServiceComposer::class);
