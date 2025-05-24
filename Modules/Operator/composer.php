<?php


view()->composer([
  'order::dashboard.orders.*',
], \Modules\Operator\ViewComposers\Dashboard\OperatorComposer::class);

view()->composer([
  'apps::clinic.index',
], \Modules\Operator\ViewComposers\Clinic\CountOperatorComposer::class);

view()->composer([
    'service::clinic.*',
    'order::clinic.orders.*',
], \Modules\Operator\ViewComposers\Clinic\OperatorComposer::class);
