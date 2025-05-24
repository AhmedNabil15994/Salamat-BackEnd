<?php

namespace Modules\Apps\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;

class FrontendController extends Controller
{
    public function home()
    {
        return view('index');
    }
}
