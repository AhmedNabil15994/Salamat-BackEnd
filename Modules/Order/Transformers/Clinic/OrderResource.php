<?php

namespace Modules\Order\Transformers\Clinic;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
           'id'                   => $this->id,
           'subtotal'             => $this->subtotal,
           'discount'             => $this->discount,
           'total'                => $this->total,
           'time_from'            => $this->time_from,
           'time_to'              => $this->time_to,
           'date'                 => $this->date,
           'service'              => $this->service->translate(locale())->title,
           'user'                 => $this->user->name,
           'doctor'               => $this->doctor ? $this->doctor->name : '',
           'operator_id'          => $this->operator ? $this->operator->name : '',
           'transaction'          => $this->transactions ? $this->transactions->method : '',
           'order_status_id'      => $this->orderStatus->translate(locale())->title,
           'deleted_at'           => $this->deleted_at,
           'created_at'           => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
