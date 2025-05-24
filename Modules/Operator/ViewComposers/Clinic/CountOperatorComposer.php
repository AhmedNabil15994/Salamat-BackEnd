<?php

namespace Modules\Operator\ViewComposers\Clinic;

use Modules\Operator\Repositories\Clinic\OperatorRepository as Operator;
use Illuminate\View\View;
use Cache;

class CountOperatorComposer
{
    public function __construct(Operator $operator)
    {
        $this->countOperators  =  $operator->countOperators();
    }

    public function compose(View $view)
    {
        $view->with('countOperators'    , $this->countOperators);
    }
}
