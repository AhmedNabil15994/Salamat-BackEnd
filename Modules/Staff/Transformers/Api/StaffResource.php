<?php

namespace Modules\Staff\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Blog\Transformers\Api\BlogResource;

class StaffResource extends JsonResource
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
       ];
    }
}
