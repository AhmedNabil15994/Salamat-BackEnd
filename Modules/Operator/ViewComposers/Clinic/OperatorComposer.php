<?php

namespace Modules\Operator\ViewComposers\Clinic;

use Modules\Operator\Repositories\Clinic\OperatorRepository as Operator;
use Illuminate\View\View;
use Cache;

class OperatorComposer
{
    public $operators = [];

    public function __construct(Operator $operator)
    {
        $this->operators =  $operator->getAllOperators();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('operators' , $this->operators);
    }
}
