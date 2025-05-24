<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OffCustomDate extends Model
{
  	use ScopesTrait;

    protected $table = 'off_custom_date';

  	protected $fillable = [ 'date' , 'time_from' , 'time_to' ];

}
