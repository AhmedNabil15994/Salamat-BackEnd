<?php

namespace Modules\Order\Repositories\Api;

use Modules\Order\Entities\OrderStatus;
use Modules\Point\Entities\UserPoint;
use Modules\Order\Entities\OrderLog;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Entities\Order;
use Carbon\Carbon;
use Auth;
use DB;

class OrderRepository
{
    function __construct(Order $order, OrderStatus $status,Coupon $coupon , UserPoint $userPoints,OrderLog $log)
    {
        $this->log        = $log;
        $this->coupon     = $coupon;
        $this->userPoints = $userPoints;
        $this->order      = $order;
        $this->status     = $status;
    }

    public function getAllOrdrsByUser()
    {
        $orders = $this->order->with([
            'doctor.clinic.clinic.branches','transactions','service.doctor.doctor.clinic.clinic.branches','service.points','orderStatus','rates'
        ])->whereHas('orderStatus', function($query) {
            $query->where('id',1)->orWhere('id',2);
        })->whereHas('service', function($query) {
           $query->where('deleted_at',null);
        })->where('user_id',auth()->id())->orderBy('id','DESC')->where('is_pending',false)->get();

        return $orders;
    }

    public function pendingOrders()
    {
        return $this->order->whereIn('order_status_id',[1,2])
                    ->with([
                        'bookedOffer.offer','doctor.clinic.clinic.branches','service','service.points','transactions','orderStatus','rates'
                    ])->whereHas('service', function($query) {
                       $query->where('deleted_at',null);
                    })
                    ->orderBy('id','DESC')
                    ->where('user_id',auth()->id())
                    ->where('is_pending',true)
                    ->get();
    }

    public function findById($id)
    {
        return $this->order->where('id',$id)->first();
    }

    public function rateOrder($request)
    {
        DB::beginTransaction();

        try {

            $order = $this->findById($request['order_id']);

            $order->rates()->updateOrCreate([
                'doctor_id' => $order['doctor_id'],
                'clinic_id' => $order->service->clinic_id,
                'user_id'   => $order['user_id'],
                'rate'      => $request['rate'],
            ]);

            DB::commit();
            return $order;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function create($service , $team ,$request , $status = false)
    {
        DB::beginTransaction();

        try {

            $coupon = 0.000;
            $discountFromPoints = 0.000;

            if ($request['coupon_id']) {
                $coupon  = $this->checkCoupon($request['coupon_id'],$team['doctor']['data']['id']);
            }

            if ($request['points']) {
                $discountFromPoints = $request['points'] / $service->points->points_per_amount;

                $service['price'] = $service['price'] - $discountFromPoints;
            }

            $discount = $coupon ? $service['price'] * ($coupon['discount'] / 100) : 0.000;

            $status = $this->statusOfOrder(false);

            $order = $this->order->create([
               'is_holding'        => 1,
               'subtotal'          => $service['price'],
               'discount'          => $discount,
               'total'             => $service['price'] - $discount,
               'date'              => $request['date'],
               'time_from'         => $request['time_from'],
               'time_to'           => $request['time_to'],
               'service_id'        => $service['id'],
               'points'            => $request['points'] ? $request['points'] : 0,
               'user_id'           => auth()->id(),
               'doctor_id'         => ($service['ignore_doctor'] == false) ? $team['doctor']['data']['id'] : null,
               'room_id'           => (isset($team['room']['data'])) ? $team['room']['data']['id'] : null,
               'operator_id'       => (isset($team['operator']['data'])) ? $team['operator']['data']['id'] : null,
               'order_status_id'   => $status->id,
            ]);

            if ($coupon) {
                $order->coupon()->create([
                    'coupon_id' => $coupon['id']
                ]);
            }

            $order->transactions()->create([
                'method' => $request['payment'],
                'result' => ($request['payment'] == 'cash') ? 'CASH' : 'Myfatoorah',
            ]);

            DB::commit();
            return $order;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($order, $service , $team ,$request , $status = false)
    {
        DB::beginTransaction();

        try {

            $coupon = false;
            $discountFromPoints = 0.000;

            if ($request['coupon_id'])
                $coupon  = $this->checkCoupon($request['coupon_id'],$team['doctor']['data']['id']);



            if ($request['points']) {
                $discountFromPoints = $request['points'] * $service->points->amount;

                $service['price'] = $service['price'] - $discountFromPoints;
            }

            $discount = $coupon ? $service['price'] * ($coupon['discount'] / 100) : 0.000;

            $status = ($request['payment'] == 'cash') ? $this->statusOfOrder(true) : $this->statusOfOrder(false);

            $order->update([
               'is_pending'        => ($request['payment'] == 'cash') ? 0 : 1,
               'is_holding'        => ($request['payment'] == 'cash') ? 0 : 1,
               'date'              => $request['date'],
               'time_from'         => $request['time_from'],
               'time_to'           => $request['time_to'],
               'points'            => $request['points'] ? $request['points'] : 0,
               'room_id'           => (isset($team['room']['data'])) ? $team['room']['data']['id'] : null,
               'operator_id'       => (isset($team['operator']['data'])) ? $team['operator']['data']['id'] : null,
               'order_status_id'   => $status->id,
            ]);

            if ($coupon) {
                $order->coupon()->create([
                    'coupon_id' => $coupon['id']
                ]);
            }

            $order->transactions()->create([
                'method' => $request['payment'],
                'result' => ($request['payment'] == 'cash') ? 'CASH' : 'Myfatoorah',
            ]);

            DB::commit();
            return $order;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateOrderAfterPayment($request,$route)
    {
        $statusOfOrder = $request['Data']['InvoiceTransactions'];

        $order = $this->findById($request['Data']['CustomerReference']);

        $this->createOrderLog($order,$request,$route);

        if ((isset($request['payment']) && $request['payment'] == 'cash')) {
            return true;
        }else{

            foreach ($statusOfOrder as $key => $transaction) {
                if ($transaction['TransactionStatus'] == 'Succss') {

                    $status = $this->statusOfOrder(true);

                    $order->update([
                        'order_status_id' => $status['id'],
                        'is_holding'      => 0,
                        'is_paid'         => 1,
                        'is_pending'      => 0,
                    ]);

                    $order->transactions()->updateOrCreate(
                      [
                          'transaction_id'  => $request['Data']['CustomerReference']
                      ],
                      [
                          'auth'          => $transaction['AuthorizationId'],
                          'tran_id'       => $transaction['TransactionId'],
                          'result'        => $transaction['TransactionStatus'],
                          'post_date'     => $request['Data']['CreatedDate'],
                          'ref'           => $request['Data']['InvoiceReference'],
                          'track_id'      => $transaction['TrackId'],
                          'payment_id'    => $request['Data']['InvoiceId'],
                    ]);

                    if (!is_null($order->service->points)) {

                        $points = $order->total / $order->service->points->amount;

                        $userPoints = $this->userPoints
                                      ->where('user_id',$order->user_id)
                                      ->where('clinic_id',$order->service->clinic_id)
                                      ->first();

                        if (!is_null($userPoints)) {
                            $userPoints->update([
                                'points'    => DB::raw('points-'.$order['points'])
                            ]);
                        }

                        $this->userPoints->updateOrCreate(
                        [
                          'clinic_id' => $order->service->clinic_id,
                          'user_id'   => $order->user_id,
                        ],
                        [
                          'points'    => DB::raw('points+'.$points),
                          'clinic_id' => $order->service->clinic_id,
                          'user_id'   => $order->user_id,
                          'status'    => true,
                        ]);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function statusOfOrder($type)
    {
        if ($type)
            $status = $this->status->successPayment()->first();

        if (!$type)
            $status = $this->status->failedPayment()->first();

        return $status;
    }

    public function checkCoupon($couponId,$doctoId)
    {
        $found = false;

        $coupon = $this->coupon
                  ->where('id',$couponId)
                  ->where('from','<=',date('Y-m-d'))
                  ->where('to','>=',date('Y-m-d'))
                  ->active()
                  ->first();

        if ($coupon && $coupon->doctor_id != null) {
            $found = ($coupon->doctor_id == $doctoId) ? true : false;
        }

        if ($coupon && $coupon->has('users')) {
            $found = ($coupon->users->contains(auth()->id())) ? true : false;
        }

        return $found ? $coupon : false;
    }

    public function createOrderLog($order,$request,$route)
    {
        $this->log->create([
            'request'   => json_encode($request),
            'route'     => $route,
            'order_id'  => $order['id'],
            'type'      => 'orders'
        ]);
    }
}
