<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Auth;

class ClinicAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if (auth()->user()->can('clinic_access') || auth()->user()->can('doctor_access') || auth()->user()->can('operator_access')){
                return $next($request);
            }

            abort(403);
        }

        return $next($request);
    }
}
