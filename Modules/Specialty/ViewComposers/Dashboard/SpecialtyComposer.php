<?php

namespace Modules\Specialty\ViewComposers\Dashboard;

use Modules\Specialty\Repositories\Dashboard\SpecialtyRepository as Specialty;
use Illuminate\View\View;
use Cache;

class SpecialtyComposer
{
    public $specialties = [];

    public function __construct(Specialty $specialty)
    {
        $this->specialties =  $specialty->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('specialties' , $this->specialties);
    }
}
