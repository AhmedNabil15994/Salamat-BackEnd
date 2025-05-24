<?php

namespace Modules\Offer\Transformers\Api;

use Modules\Service\Transformers\Api\ServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookedOfferResource extends JsonResource
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
            'order_status'       => $this->orderStatus->translate(locale())->title,
            'offer'              => new OfferResource($this->whenLoaded('offer')),
       ];
    }
}
