<?php

namespace Modules\Availability\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OffDatesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          'date_from' => $this->date_from,
          'date_to'   => $this->date_to,
       ];
    }
}
