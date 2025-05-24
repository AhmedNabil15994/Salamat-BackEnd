<?php

namespace Modules\Doctor\ViewComposers\Clinic;

use Modules\Doctor\Repositories\Clinic\DoctorRepository as Doctor;
use Illuminate\View\View;
use Cache;

class CountDoctorComposer
{
    public function __construct(Doctor $doctor)
    {
        $this->countDoctors  =  $doctor->countDoctors();
    }

    public function compose(View $view)
    {
        $view->with('countDoctors'    , $this->countDoctors);
    }
}
