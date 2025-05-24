<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Point\Transformers\Api\PointResource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'name'          => $this->name,
           'email'         => $this->email,
           'phone_code'    => $this->phone_code,
           'mobile'        => $this->mobile,
           'image'         => url($this->image),
           'my_points'     => PointResource::collection($this->points),
       ];
    }
}
