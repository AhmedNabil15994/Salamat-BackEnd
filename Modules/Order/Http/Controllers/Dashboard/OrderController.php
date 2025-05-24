<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Http\Requests\Dashboard\OrderRequest;
use Modules\Order\Transformers\Dashboard\OrderResource;
use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as Status;
use Modules\Order\Notifications\Api\ResponseOrderNotification;
use Modules\Transaction\Services\MyFatorahPaymentService;
use Modules\Order\Repositories\Api\OrderRepository as OrderAPI;
use Notification;

class OrderController extends Controller
{

    function __construct(Order $order,Status $status, MyFatorahPaymentService $payment , OrderAPI $orderAPI)
    {
        $this->orderAPI = $orderAPI;
        $this->payment = $payment;
        $this->status = $status;
        $this->order  = $order;
    }

    public function index()
    {
        return view('order::dashboard.orders.index');
    }

    public function calendar(Request $request)
    {
        $orders = $this->order->getSuccessfullyOrders($request);
        return view('order::dashboard.orders.calendar',compact('orders'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        // $this->order->updateUnread($id);
        $order = $this->order->findById($id);
        //
        // Notification::route('mail', $order->email)
        // ->notify((new ResponseOrderNotification($order))->locale(locale()));
        $statuses = $this->status->getAll();

        return view('order::dashboard.orders.show',compact('order','statuses'));
    }

    public function update(Request $request, $id)
    {
        try {

            $update = $this->order->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->order->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function logs($id,$type)
    {
        // $payment = $this->payment->paymentStatus(['paymentId' => '0808195605841832672884']);
        // return $order = $this->orderAPI->updateOrderAfterPayment($payment,'SuccessURL');

        $orders = $this->order->getLogsByOrderId($id,$type);

        return collect($orders)->map(function ($name) {
            return json_decode($name['request']);
        });
    }
}
