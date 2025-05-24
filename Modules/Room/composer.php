<?php

view()->composer([
  'apps::clinic.index',
  'service::clinic.*',
], \Modules\Room\ViewComposers\Clinic\CountRoomComposer::class);

view()->composer([
    'service::clinic.*',
    'order::clinic.orders.*',
], \Modules\Room\ViewComposers\Clinic\RoomComposer::class);
