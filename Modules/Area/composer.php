<?php

view()->composer(['area::dashboard.cities.*'], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);

view()->composer([
    'area::dashboard.states.*',
    'clinic::dashboard.*',
    'clinic::clinic.*',
], \Modules\Area\ViewComposers\Dashboard\CityComposer::class);
