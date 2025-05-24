<?php

view()->composer([
  'blog::dashboard.*',
  'service::dashboard.*',
  'clinic::dashboard.*',
  'coupon::dashboard.*',
  'order::dashboard.orders.*',
], \Modules\Doctor\ViewComposers\Dashboard\DoctorComposer::class);

view()->composer([
  'blog::clinic.*',
  'coupon::clinic.*',
  'order::clinic.orders.*',
  'service::clinic.*',
], \Modules\Doctor\ViewComposers\Clinic\DoctorComposer::class);

view()->composer([
  'apps::clinic.index',
], \Modules\Doctor\ViewComposers\Clinic\CountDoctorComposer::class);
