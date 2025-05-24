<?php

namespace Modules\Doctor\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorSocialMediaResource extends JsonResource
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
           'name'         => $this->name,
           'link'         => $this->link,
       ];
    }
}
