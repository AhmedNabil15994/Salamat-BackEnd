<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Service\Transformers\Api\ServiceResource;

class CategoryResource extends JsonResource
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
           'id'             => $this->id,
           'image'          => url($this->image),
           'title'          => $this->translate(locale())->title,
           'description'    => htmlView($this->translate(locale())->description),
           'services'       => ServiceResource::collection($this->whenLoaded('services')),
       ];
    }
}
