<?php

namespace Modules\Point\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Clinic\Transformers\Api\ClinicResource;

class PointResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'points'        => $this->points,
           'clinic'        => new ClinicResource($this->clinic)
       ];
    }
}
