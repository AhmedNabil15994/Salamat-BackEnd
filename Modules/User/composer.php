<?php

view()->composer([
    'apps::dashboard.index',
    'coupon::dashboard.*',
    'order::dashboard.orders.*',
], \Modules\User\ViewComposers\Dashboard\UserComposer::class);


view()->composer([
    'coupon::clinic.*',
    'order::clinic.orders.*',
], \Modules\User\ViewComposers\Clinic\ClinicUsersComposer::class);
