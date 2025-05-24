<?php

namespace Modules\Clinic\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ClinicBrancheResource extends JsonResource
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
            'id'                    => $this->id,
            'lat'                   => $this->lat,
            'lang'                  => $this->lang,
            'block'                 => $this->block,
            'street'                => $this->street,
            'building'              => $this->building,
            'phone_number'          => $this->phone_number,
            'another_phone_number'  => $this->another_phone_number,
            'address_details'       => $this->address_details,
            'city'                  => $this->state->city->translate(locale())->title,
            'state_id'              => $this->state->id,
            'state'                 => $this->state->translate(locale())->title,
       ];
    }
}
