<?php

namespace Modules\Availability\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OffDaysResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          'day'   => $this->day,
       ];
    }
}
