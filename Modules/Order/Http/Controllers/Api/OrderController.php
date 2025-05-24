<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Order\Transformers\Api\OrderResource;
use Modules\Availability\Traits\AvailabilityTrait;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Order\Http\Requests\Api\CreateOrderRequest;
use Modules\Transaction\Services\MyFatorahPaymentService;
use Modules\Order\Repositories\Api\OrderRepository as Order;
use Modules\Service\Repositories\Api\ServiceRepository as Service;
use Illuminate\Support\MessageBag;

class OrderController extends ApiController
{
    use AvailabilityTrait;

    function __construct(Order $order , MyFatorahPaymentService $payment, Service $service)
    {
        $this->service = $service;
        $this->order   = $order;
        $this->payment = $payment;
    }

    public function request(CreateOrderRequest $request)
    {
        // return $payment = $this->payment->send(['test'=>'test'],'api-order',$request['payment']);
        $service = $this->service->findById($request['service_id']);

        $team = $this->availabilityChecker($service,$request);

        $result = $result = (
            is_null($team['doctor']['error']) &&
            (($team['room'] == false) || is_null($team['room']['error'])) &&
            (($team['operator'] == false) || is_null($team['operator']['error'])) ) ? true : false;

        if ($result)
            return $this->goToPayment($service,$team,$request);

        return $this->invalidData(
            new MessageBag(['availability' => __('order::api.orders.validations.availability.not_available') ])
        );
    }

    public function goToPayment($service,$team,$request)
    {
        $order =  $this->order->create($service,$team,$request);

        if (!$order)
            return $this->error('error' , [] , 401);

        if ($request['payment'] != 'cash'){

            $payment = $this->payment->send($order,'api-order',$request['payment'],$service->clinic);

            return $this->response([
                'paymentUrl' => $payment['Data']['InvoiceURL']
            ]);
        }

        return $this->response(new OrderResource($order));
    }

    public function pendingRequest(Request $request)
    {
        $order = $this->order->findById($request['order_id']);

        $service = $this->service->findById($order['service_id']);

        $team = $this->availabilityChecker($service,$request);

        $result = $result = (
            is_null($team['doctor']['error']) &&
            (($team['room'] == false) || is_null($team['room']['error'])) &&
            (($team['operator'] == false) || is_null($team['operator']['error'])) ) ? true : false;

        if ($result)
            return $this->goToPendingPayment($order,$service,$team,$request);

        return $this->invalidData(
            new MessageBag(['availability' => __('order::api.orders.validations.availability.not_available') ])
        );
    }

    public function goToPendingPayment($order,$service,$team,$request)
    {
        $order =  $this->order->update($order,$service,$team,$request);

        if (!$order)
            return $this->error('error' , [] , 401);

        if ($request['payment'] != 'cash'){

            $payment = $this->payment->send($order,'api-order',$request['payment'],$service->clinic);

            return $this->response([
                'paymentUrl' => $payment['Data']['InvoiceURL']
            ]);
        }

        return $this->response(new OrderResource($order));
    }

    public function success(Request $request)
    {
        $payment = $this->payment->paymentStatus($request);

        $order = $this->order->updateOrderAfterPayment($payment,'SuccessURL');

        if ($order) {
            $order = $this->order->findById($payment['Data']['CustomerReference']);
            return $this->response(new OrderResource($order));
        }

        return $this->error('error' , [], 401);
    }

    public function failed(Request $request)
    {
        $payment = $this->payment->paymentStatus($request);

        $order = $this->order->updateOrderAfterPayment($payment,'ErrorURL');

        if ($order) {
            $order = $this->order->findById($payment['Data']['CustomerReference']);
            return $this->response(new OrderResource($order));
        }

        return $this->error('error' , [], 401);

    }

    public function list(Request $request)
    {
        $orders = $this->order->getAllOrdrsByUser();

        return OrderResource::collection($orders);
    }

    public function rate(Request $request)
    {
        $this->order->rateOrder($request);

        $order = $this->order->findById($request['order_id']);

        return $this->response(new OrderResource($order));
    }

    public function pending(Request $request)
    {
        $orders = $this->order->pendingOrders();

        return OrderResource::collection($orders);
    }
}
