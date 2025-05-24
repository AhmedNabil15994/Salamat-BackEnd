<?php

view()->composer([
  'doctor::dashboard.services.*',
  'service::dashboard.*',
  'service::clinic.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);
