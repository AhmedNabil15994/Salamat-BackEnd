<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Shift extends Model
{
  	use ScopesTrait;

    protected $table = 'shift';

  	protected $fillable = [ 'start_time' , 'end_time' ];

}
