<?php

view()->composer(['user::dashboard.admins.index'], \Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer::class);


view()->composer([
    'doctor::clinic.doctors.*',
    'doctor::dashboard.doctors.*',
], \Modules\Authorization\ViewComposers\Dashboard\DoctorRolesComposer::class);


view()->composer([
    'operator::dashboard.operators.*',
    'operator::clinic.operators.*',
], \Modules\Authorization\ViewComposers\Dashboard\OperatorRolesComposer::class);


view()->composer([
    'room::dashboard.rooms.*',
    'room::clinic.rooms.*',
], \Modules\Authorization\ViewComposers\Dashboard\RoomRolesComposer::class);


view()->composer([
    'staff::dashboard.staffs.*',
    'staff::clinic.staffs.*',
], \Modules\Authorization\ViewComposers\Dashboard\StaffRolesComposer::class);
