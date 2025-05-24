<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceRoom extends Model
{
    protected $fillable = ['service_id' , 'room_id'];

    public function room()
    {
        return $this->belongsTo('Modules\Room\Entities\Room','room_id','id');
    }

    public function service()
    {
        return $this->belongsTo('Modules\Service\Entities\Service','service_id','id');
    }
}
