<?php

view()->composer([
    'apps::dashboard.index',
],  \Modules\Order\ViewComposers\Dashboard\OrderComposer::class);


view()->composer([
    'order::dashboard.orders.index',
    'order::clinic.orders.index',
],  \Modules\Order\ViewComposers\Dashboard\OrderStatusComposer::class);


view()->composer([
    'apps::clinic.index',
],  \Modules\Order\ViewComposers\Clinic\OrderComposer::class);
