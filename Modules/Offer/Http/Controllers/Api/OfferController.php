<?php

namespace Modules\Offer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Offer\Transformers\Api\BookedOfferResource;
use Modules\Offer\Transformers\Api\OfferResource;
use Modules\Offer\Repositories\Api\OfferRepository as Offer;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Transaction\Services\MyFatorahPaymentService;

class OfferController extends ApiController
{

    function __construct(Offer $offer , MyFatorahPaymentService $payment)
    {
        $this->offer    = $offer;
        $this->payment  = $payment;
    }

    public function booking(Request $request)
    {
        $offer = $this->offer->findOfferById($request['offer_id']);

        if ($offer)
            return $this->goToPayment($offer,$request);

        return $this->response([]);
    }

    public function goToPayment($offer,$request)
    {
        $booked =  $this->offer->create($offer,$request);

        if (!$booked)
            return $this->error('error' , [] , 401);

        if ($request['payment'] != 'cash'){

            $payment = $this->payment->send($booked,'api-offer',$request['payment'],$offer->clinic);

            return $this->response([
                'paymentUrl' => $payment['Data']['InvoiceURL']
            ]);
        }

        return $this->response(new BookedOfferResource($booked));
    }

    public function success(Request $request)
    {
        $payment = $this->payment->paymentStatus($request);

        $booked = $this->offer->updateOffer($payment,'SuccessURL');

        if ($booked) {

            $booked = $this->offer->findBookedOfferById($payment['Data']['CustomerReference']);
            return $this->response(new BookedOfferResource($booked));
        }

        return $this->error('error' , [], 401);
    }

    public function failed(Request $request)
    {
        $payment = $this->payment->paymentStatus($request);

        $booked = $this->offer->updateOffer($payment,'ErrorURL');

        if ($booked) {

            $booked = $this->offer->findBookedOfferById($payment['Data']['CustomerReference']);
            return $this->response(new BookedOfferResource($booked));
        }

        return $this->error('error' , [], 401);
    }

    public function list(Request $request)
    {
        $offers = $this->offer->getAllByUser();

        return BookedOfferResource::collection($offers);
    }
}
