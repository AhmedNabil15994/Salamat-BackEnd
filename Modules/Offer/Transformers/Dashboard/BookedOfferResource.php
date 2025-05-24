<?php

namespace Modules\Offer\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class BookedOfferResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'total'              => $this->total,
           'offer_id'           => $this->offer->translate(locale())->title,
           'user_id'            => $this->user->name,
           'order_status_id'    => $this->orderStatus->translate(locale())->title,
           'transaction'        => $this->transactions ? $this->transactions->method : '',
           'deleted_at'         => $this->deleted_at,
           'created_at'         => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
