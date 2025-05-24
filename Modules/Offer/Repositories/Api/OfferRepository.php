<?php

namespace Modules\Offer\Repositories\Api;

use Modules\Order\Entities\OrderStatus;
use Modules\Offer\Entities\BookedOffer;
use Modules\Offer\Entities\Offer;
use Modules\Order\Entities\OrderLog;
use DB;

class OfferRepository
{

    function __construct(Offer $offer,BookedOffer $booked,OrderStatus $status,OrderLog $log)
    {
        $this->log     = $log;
        $this->status  = $status;
        $this->booked  = $booked;
        $this->offer   = $offer;
    }

    public function findBookedOfferById($id)
    {
        return $this->booked->with('offer.services')->where('id',$id)->first();
    }

    public function findOfferById($id)
    {
        return $this->offer->where('id',$id)->first();
    }

    public function create($offer,$request,$status = false)
    {
        DB::beginTransaction();


        try {

            $offer = $this->findOfferById($request['offer_id']);
            $status = $this->statusOfOrder(false);

            $booked = $this->booked->create([
               'is_holding'        => true,
               'total'             => $offer['price'],
               'offer_id'          => $offer['id'],
               'user_id'           => auth()->id(),
               'order_status_id'   => $status->id,
            ]);

            $booked->transactions()->create([
                'method' => $request['payment'],
                'result' => ($request['payment'] == 'cash') ? 'CASH' : 'Myfatoorah',
            ]);

            foreach ($offer->services as $key => $service) {
                $order = $booked->orders()->create([
                    'is_holding'        => false,
                    'is_pending'        => true,
                    'is_paid'           => true,
                    'subtotal'          => 0.000,
                    'discount'          => 0.000,
                    'total'             => 0.000,
                    'date'              => null,
                    'time_from'         => null,
                    'time_to'           => null,
                    'service_id'        => $service['id'],
                    'user_id'           => auth()->id(),
                    'doctor_id'         => null,
                    'room_id'           => null,
                    'operator_id'       => null,
                    'order_status_id'   => $status->id,
                ]);

                $order->transactions()->create([
                    'method' => 'Offer',
                    'result' => 'Offer',
                ]);
            }

            DB::commit();
            return $booked;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateOffer($request,$route)
    {
        $statusOfOffer = $request['Data']['InvoiceTransactions'];

        $booked = $this->findBookedOfferById($request['Data']['CustomerReference']);

        $this->createOrderLog($booked,$request,$route);

        foreach ($statusOfOffer as $key => $transaction) {

            if ($transaction['TransactionStatus'] == 'Succss') {

                $status = $this->statusOfOrder(true);

                $booked->update([
                  'order_status_id' => $status['id'],
                  'is_holding'      => false
                ]);

                foreach ($booked->orders as $key => $order) {

                    $order->update([
                        'order_status_id' => 1,
                    ]);

                    $order->transactions()->updateOrCreate(
                      [
                        'transaction_id'  => $order['id']
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

                }

                $booked->transactions()->updateOrCreate(
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

                return true;
            }

            return false;
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

    public function createOrderLog($order,$request,$route)
    {
        $this->log->create([
            'request'   => json_encode($request),
            'route'     => $route,
            'order_id'  => $order['id'],
            'type'      => 'offers'
        ]);
    }

}
