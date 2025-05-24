<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceOperator extends Model
{
    protected $fillable = ['service_id' , 'operator_id'];

    public function operator()
    {
        return $this->belongsTo('Modules\Operator\Entities\Operator','operator_id','id');
    }

    public function service()
    {
        return $this->belongsTo('Modules\Service\Entities\Service','service_id','id');
    }
}
