<?php

namespace Modules\Point\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Point extends Model
{
    use ScopesTrait;

  	protected $fillable = [ 'status' , 'amount' , 'service_id' , 'points_per_amount'];

    public function service()
    {
        return $this->belongsTo(\Modules\Service\Entities\Service::class , 'point_services');
    }
}
