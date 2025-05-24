<?php

namespace Modules\Staff\ViewComposers\Dashboard;

use Modules\Staff\Repositories\Dashboard\StaffRepository as Staff;
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
