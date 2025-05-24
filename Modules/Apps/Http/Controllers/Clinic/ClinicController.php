<?php

namespace Modules\Apps\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ClinicController extends Controller
{
    public function index()
    {
        return view('apps::clinic.index');
    }
}
