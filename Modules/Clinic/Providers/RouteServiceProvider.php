<?php

namespace Modules\Clinic\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
     protected $apiModule       = '\Modules\Clinic\Http\Controllers\Api';
     protected $frontendModule  = '\Modules\Clinic\Http\Controllers\Frontend';
     protected $dashboardModule = '\Modules\Clinic\Http\Controllers\Dashboard';
     protected $clinicModule    = '\Modules\Clinic\Http\Controllers\Clinic';

    protected function mapDashboardRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize', "permission:dashboard_access")
        ->prefix(LaravelLocalization::setLocale().'/dashboard')
        ->namespace($this->dashboardModule)->group(module_path('Clinic', 'Routes/dashboard/routes.php'));

    }

    protected function mapClinicRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale().'/clinic')
        ->namespace($this->clinicModule)->group(module_path('Clinic', 'Routes/clinic/routes.php'));

    }

    protected function mapWebRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale())
        ->namespace($this->frontendModule)->group(module_path('Clinic', 'Routes/frontend/routes.php'));
    }

    protected function mapApiRoutes()
    {
        Route::group(
            [
                'prefix'=>'api' ,'middleware' => ['api'] ,
                'namespace' => $this->apiModule
            ],
            module_path('Clinic', 'Routes/api/routes.php')
        );
    }
}
