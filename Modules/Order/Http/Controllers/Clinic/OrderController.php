<?php

namespace Modules\Order\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Http\Requests\Clinic\OrderRequest;
use Modules\Order\Transformers\Clinic\OrderResource;
use Modules\Order\Repositories\Clinic\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as Status;
use Modules\Order\Notifications\Api\ResponseOrderNotification;
use Notification;

class OrderController extends Controller
{
    function __construct(Order $order,Status $status)
    {
        $this->status = $status;
        $this->order = $order;
    }

    public function create()
    {
        return view('order::clinic.orders.create');
    }

    public function calendar(Request $request)
    {
        $orders = $this->order->getSuccessfullyOrders($request);
        return view('order::clinic.orders.calendar',compact('orders'));
    }

    public function store(Request $request)
    {
        try {
            $create = $this->order->create($request);

            if ($create) {
                return Response()->json([true , __('apps::clinic.messages.created')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function index()
    {
        return view('order::clinic.orders.index');
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
        $statuses = $this->status->getAll();

        // Notification::route('mail', $order->email)
        // ->notify((new ResponseOrderNotification($order))->locale(locale()));

        return view('order::clinic.orders.show',compact('order','statuses'));
    }

    public function update(Request $request, $id)
    {
        try {

            $update = $this->order->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::clinic.messages.updated')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->order->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
