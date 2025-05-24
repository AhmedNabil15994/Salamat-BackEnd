<?php

namespace Modules\Coupon\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Service\Transformers\Api\ServiceResource;

class CouponResource extends JsonResource
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
           'id'            => $this->id,
           'code'          => $this->code,
           'discount'      => $this->discount,
           'from'          => $this->from,
           'to'            => $this->to,
           'status'        => $this->status,
       ];
    }
}
