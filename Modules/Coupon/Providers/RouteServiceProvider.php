<?php

namespace Modules\Coupon\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
     protected $apiModule       = '\Modules\Coupon\Http\Controllers\Api';
     protected $frontendModule  = '\Modules\Coupon\Http\Controllers\Frontend';
     protected $dashboardModule = '\Modules\Coupon\Http\Controllers\Dashboard';
     protected $clinicModule    = '\Modules\Coupon\Http\Controllers\Clinic';

    protected function mapDashboardRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize', "permission:dashboard_access")
        ->prefix(LaravelLocalization::setLocale().'/dashboard')
        ->namespace($this->dashboardModule)->group(module_path('Coupon', 'Routes/dashboard/routes.php'));

    }

    protected function mapClinicRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale().'/clinic')
        ->namespace($this->clinicModule)->group(module_path('Coupon', 'Routes/clinic/routes.php'));

    }

    protected function mapWebRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale())
        ->namespace($this->frontendModule)->group(module_path('Coupon', 'Routes/frontend/routes.php'));
    }

    protected function mapApiRoutes()
    {
        Route::group(
            [
                'prefix'=>'api' ,'middleware' => ['api'] ,
                'namespace' => $this->apiModule
            ],
            module_path('Coupon', 'Routes/api/routes.php')
        );
    }
}
