<?php

namespace Modules\Specialty\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Doctor\Transformers\Api\DoctorResource;

class SpecialtyResource extends JsonResource
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
           'title'         => $this->translate(locale())->title,
           'image'         => url($this->image),
           'doctors'       => DoctorResource::collection($this->whenLoaded('doctors')),
       ];
    }
}
