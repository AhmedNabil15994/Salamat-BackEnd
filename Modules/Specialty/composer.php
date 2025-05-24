<?php

view()->composer([
    'doctor::dashboard.doctors.*',
    'doctor::clinic.doctors.*'
], \Modules\Specialty\ViewComposers\Dashboard\SpecialtyComposer::class);
