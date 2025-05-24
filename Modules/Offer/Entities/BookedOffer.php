<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class BookedOffer extends Model
{
    use ScopesTrait , SoftDeletes;

  	protected $fillable = ['total' , 'offer_id' , 'unread' , 'order_status_id' , 'user_id'];

    public function orderStatus()
    {
        return $this->belongsTo(\Modules\Order\Entities\OrderStatus::class);
    }

    public function offer()
    {
        return $this->belongsTo(\Modules\Offer\Entities\Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    public function transactions()
    {
        return $this->morphOne(\Modules\Transaction\Entities\Transaction::class, 'transaction');
    }
}
