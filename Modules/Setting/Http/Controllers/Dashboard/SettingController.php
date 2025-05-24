<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Repositories\Dashboard\SettingRepository as Setting;

class SettingController extends Controller
{
    function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        return view('setting::dashboard.index');
    }

    public function update(Request $request)
    {
        $this->setting->set($request);

        return redirect()->back();
    }

}
