<?php

namespace Modules\Staff\ViewComposers\Clinic;

use Modules\Staff\Repositories\Clinic\StaffRepository as Staff;
use Illuminate\View\View;
use Cache;

class StaffComposer
{
    public $staffs = [];

    public function __construct(Staff $staff)
    {
        $this->staffs =  $staff->getAllStaffs();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('staffs' , $this->staffs);
    }
}
