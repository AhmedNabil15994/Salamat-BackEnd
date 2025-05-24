<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OffDates extends Model
{
  	use ScopesTrait;

    protected $table = 'off_dates';

  	protected $fillable = [ 'date_from' , 'date_to' ];

}
