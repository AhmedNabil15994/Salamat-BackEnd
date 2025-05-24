<?php

namespace Modules\Clinic\Transformers\Api;

use Modules\Availability\Transformers\Api\AvailabilityResource;
use Modules\Doctor\Transformers\Api\DoctorResource;
use Modules\Offer\Transformers\Api\OfferResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Blog\Transformers\Api\BlogResource;

class ClinicResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'image'         => url($this->image),
           'title'         => $this->translate(locale())->title,
           'description'   => htmlView($this->translate(locale())->description),
           'open_time_message'   => $this->translate(locale())->open_time_message,
           'offers'        => OfferResource::collection($this->whenLoaded('offers')),
           'doctors'       => DoctorResource::collection($this->whenLoaded('doctors')),
           'gallery'       => ClinicGalleryResource::collection($this->whenLoaded('gallery')),
           'social_media'  => ClinicSocialMediaResource::collection($this->whenLoaded('socialMedia')),
           'contacts'      => ClinicContactResource::collection($this->whenLoaded('contacts')),
           'blogs'         => BlogResource::collection($this->whenLoaded('blogs')),
           'address'       => new ClinicBrancheResource($this->whenLoaded('branches')),
           'rate'          => $this->whenLoaded('profile', function () {
               return number_format($this->rate()->avg('rate'), 1);
           }),
           'start_time'    => $this->whenLoaded('shift', function () {
               return $this->shift->start_time;
           }),
           'end_time'      => $this->whenLoaded('shift', function () {
               return $this->shift->end_time;
           }),
           'availability'   => new AvailabilityResource($this),
        ];
    }
}
