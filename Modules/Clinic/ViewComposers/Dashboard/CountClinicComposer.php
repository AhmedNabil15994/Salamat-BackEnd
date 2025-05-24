<?php

namespace Modules\Clinic\ViewComposers\Dashboard;

use Modules\Clinic\Repositories\Dashboard\ClinicRepository as Clinic;
use Illuminate\View\View;
use Cache;

class CountClinicComposer
{
    public $clinics = [];

    public function __construct(Clinic $clinic)
    {
        $this->countClinics =  $clinic->countClinics();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('countClinics' , $this->countClinics);
    }
}
