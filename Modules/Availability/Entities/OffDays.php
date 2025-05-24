<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OffDays extends Model
{
  	use ScopesTrait;

    protected $table = 'off_days';

  	protected $fillable = ['day' , 'start_time' ,'end_time'];

}
