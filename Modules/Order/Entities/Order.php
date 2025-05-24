<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Order extends Model
{
    use SoftDeletes , ScopesTrait;

    protected $fillable = [
      'unread',
      'is_finished',
      'is_holding',
      'date',
      'time_to',
      'time_from',
      'subtotal',
      'discount',
      'total',
      'user_id',
      'service_id',
      'doctor_id',
      'room_id',
      'operator_id',
      'booked_offer_id',
      'order_status_id',
      'is_pending',
      'is_paid',
      'points'
    ];

    public function transactions()
    {
        return $this->morphOne(\Modules\Transaction\Entities\Transaction::class, 'transaction');
    }

    public function doctor()
    {
        return $this->belongsTo(\Modules\Doctor\Entities\Doctor::class);
    }

    public function offer()
    {
        return $this->belongsTo(\Modules\Offer\Entities\Offer::class);
    }

    public function service()
    {
        return $this->belongsTo(\Modules\Service\Entities\Service::class);
    }

    public function room()
    {
        return $this->belongsTo(\Modules\Room\Entities\Room::class);
    }

    public function operator()
    {
        return $this->belongsTo(\Modules\Operator\Entities\Operator::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function rates()
    {
        return $this->hasOne(OrderRate::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function bookedOffer()
    {
        return $this->belongsTo(\Modules\Offer\Entities\BookedOffer::class);
    }

    public function coupon()
    {
        return $this->hasOne(OrderCoupon::class);
    }
}
