<?php

namespace Modules\Doctor\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorContactResource extends JsonResource
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
           'mobile'        => $this->mobile,
       ];
    }
}
