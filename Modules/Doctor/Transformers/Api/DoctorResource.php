<?php

namespace Modules\Doctor\Transformers\Api;

use Modules\Availability\Transformers\Api\AvailabilityResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Blog\Transformers\Api\BlogResource;
use Modules\Clinic\Transformers\Api\ClinicResource;
use Modules\Order\Transformers\Api\OrderResource;

class DoctorResource extends JsonResource
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
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'image'         => url($this->image),
            'name_trans'    => optional(
                optional($this->profile)->translate(locale())
            )->name,
            'job' => $this->whenLoaded('profile', function () {
                return $this->profile->translate(locale())->job_title;
            }),
            'about' => $this->whenLoaded('profile', function () {
                return $this->profile->translate(locale())->about;
            }),
            'open_time_message' => $this->whenLoaded('profile', function () {
                return $this->profile->translate(locale())->open_time_message;
            }),
            'clinic' => $this->whenLoaded('clinic', function () {
                return new ClinicResource($this->clinic->clinic);
            }),
            'social_media'  => DoctorSocialMediaResource::collection($this->whenLoaded('socialMedia')),
            'contacts'      => DoctorContactResource::collection($this->whenLoaded('contacts')),
            'specialties'   => DoctorSpecialtyResource::collection($this->whenLoaded('specialties')),
            'blogs'         => BlogResource::collection($this->whenLoaded('blogs')),
            'rate'          => $this->whenLoaded('rates', function () {
                return number_format($this->rates()->avg('rate'), 1);
            }),
            'upocming_orders' => $this->whenLoaded('upcomingOrders', function () {
                return OrderResource::collection($this->upcomingOrders);
            }),
        ];
    }
}
