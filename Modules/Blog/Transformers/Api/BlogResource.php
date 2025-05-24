<?php

namespace Modules\Blog\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
           'video'          => $this->video,
           'title'          => $this->translate(locale())->title,
           'description'    => htmlView($this->translate(locale())->description),
       ];
    }
}
