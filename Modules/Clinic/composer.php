<?php

view()->composer([
  'apps::dashboard.index',
], \Modules\Clinic\ViewComposers\Dashboard\CountClinicComposer::class);

view()->composer([
    'offer::dashboard.*',
    'category::dashboard.*',
    'service::dashboard.*',
    'blog::dashboard.*',
    'room::dashboard.rooms.*',
    'doctor::dashboard.doctors.*',
    'operator::dashboard.operators.*',
    'staff::dashboard.staffs.*',
    'order::dashboard.orders.*',
    'coupon::dashboard.*',
], \Modules\Clinic\ViewComposers\Dashboard\ClinicComposer::class);


view()->composer([
    'offer::clinic.*',
    'category::clinic.*',
    'service::clinic.*',
    'blog::clinic.*',
    'room::clinic.rooms.*',
    'doctor::clinic.doctors.*',
    'operator::clinic.operators.*',
    'staff::clinic.staffs.*',
], \Modules\Clinic\ViewComposers\Clinic\ClinicComposer::class);
