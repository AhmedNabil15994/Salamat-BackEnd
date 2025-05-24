<?php

namespace Modules\Availability\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'start_time'    => $this->shift->start_time,
            'end_time'      => $this->shift->end_time,
            'off_days'      => OffDaysResource::collection($this->offDays),
       ];
    }
}
