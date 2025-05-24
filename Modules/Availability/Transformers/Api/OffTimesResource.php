<?php

namespace Modules\Availability\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OffTimesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          'time_from'   => $this->time_from,
          'time_to'     => $this->time_to,
       ];
    }
}
