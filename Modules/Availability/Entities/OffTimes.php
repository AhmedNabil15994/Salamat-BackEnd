<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OffTimes extends Model
{
  	use ScopesTrait;

    protected $table = 'off_times';

  	protected $fillable = [ 'time_from' , 'time_to' ];

}
