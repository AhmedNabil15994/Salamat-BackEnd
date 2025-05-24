<?php

namespace Modules\Order\ViewComposers\Clinic;

use Modules\Order\Repositories\Clinic\OrderStatusRepository as OrderStatus;
use Illuminate\View\View;
use Cache;

class OrderStatusComposer
{
    public function __construct(OrderStatus $status)
    {
        $this->statuses = $status->getAll();
    }

    public function compose(View $view)
    {
        $view->with('statuses'   , $this->statuses);
    }
}
