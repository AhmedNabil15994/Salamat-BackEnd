<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $fillable = [
      'request',
      'route',
      'order_id',
      'type'
    ];
}
