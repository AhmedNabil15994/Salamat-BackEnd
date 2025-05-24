<?php

namespace Modules\Clinic\ViewComposers\Clinic;

use Modules\Clinic\Repositories\Clinic\ClinicRepository as Clinic;
use Illuminate\View\View;
use Cache;

class ClinicComposer
{
    public $clinics = [];

    public function __construct(Clinic $clinic)
    {
        $this->clinics =  $clinic->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('clinics' , $this->clinics);
    }
}
