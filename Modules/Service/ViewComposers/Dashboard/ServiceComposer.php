<?php

namespace Modules\Service\ViewComposers\Dashboard;

use Modules\Service\Repositories\Dashboard\ServiceRepository as Service;
use Illuminate\View\View;
use Cache;

class ServiceComposer
{
    public $services = [];

    public function __construct(Service $service)
    {
        $this->services =  $service->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('services' , $this->services);
    }
}
