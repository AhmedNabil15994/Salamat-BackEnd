<?php

namespace Modules\Offer\ViewComposers\Dashboard;

use Modules\Offer\Repositories\Dashboard\OfferRepository as Offer;
use Illuminate\View\View;
use Cache;

class OfferComposer
{
    public $offers = [];

    public function __construct(Offer $offer)
    {
        $this->offers =  $offer->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('offers' , $this->offers);
    }
}
