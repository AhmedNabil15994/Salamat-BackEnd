<?php

namespace Modules\Service\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class ServiceResource extends Resource
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
           'price'         => $this->price,
           'description'   => $this->description,
           'status'        => $this->status,
           'time_to_take'  => $this->time_to_take,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
