<?php

namespace Modules\Doctor\ViewComposers\Clinic;

use Modules\Doctor\Repositories\Clinic\DoctorRepository as Doctor;
use Illuminate\View\View;
use Cache;

class DoctorComposer
{
    public $doctors = [];

    public function __construct(Doctor $doctor)
    {
        $this->doctors =  $doctor->getAllDoctors();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('doctors' , $this->doctors);
    }
}
