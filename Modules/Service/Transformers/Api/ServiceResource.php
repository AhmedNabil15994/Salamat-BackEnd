<?php

namespace Modules\Service\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Availability\Traits\ShiftTrait;
use Modules\Doctor\Transformers\Api\DoctorResource;
use Modules\Order\Transformers\Api\OrderResource;

class ServiceResource extends JsonResource
{
    use ShiftTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id'                     => $this->id,
           'title'                  => $this->translate(locale())->title,
           'image'                  => url($this->image),
           'price'                  => $this->price,
           'ignore_doctor'          => $this->ignore_doctor,
           // 'doctor'                 => $this->doctor->doctor->name,
           // 'doctor_img'             => url($this->doctor->doctor->image),
           'one_point_per_amount'=> $this->whenLoaded('points', function() {
               return $this->points->amount;
           }),
           'points_per_amount'=> $this->whenLoaded('points', function() {
               return $this->points->points_per_amount;
           }),
           'availabilty'=> $this->whenLoaded('doctor', function() {
               return $this->availabiltyTimes($this->doctor->doctor,$this->service_take_time);
           }),
           'upocming_orders'=> $this->whenLoaded('doctor', function() {
               return OrderResource::collection($this->doctor->doctor->upcomingOrders);
           }),
           'is_consultation'        => $this->is_consultation,
           'service_take_time'      => $this->service_take_time,
           'description'            => htmlView($this->translate(locale())->description),
       ];
    }
}
