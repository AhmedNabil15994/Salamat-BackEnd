<?php

view()->composer(['worker::dashboard.workers.*'],
 \Modules\Setting\ViewComposers\Dashboard\CountriesCodeComposer::class);
