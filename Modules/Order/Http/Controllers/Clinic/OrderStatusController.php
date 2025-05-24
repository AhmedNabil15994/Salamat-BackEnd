<?php

namespace Modules\Order\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Http\Requests\Clinic\OrderStatusRequest;
use Modules\Order\Transformers\Clinic\OrderStatusResource;
use Modules\Order\Repositories\Clinic\OrderStatusRepository as OrderStatus;

class OrderStatusController extends Controller
{

    function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function index()
    {
        return view('order::clinic.order-statuses.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->orderStatus->QueryTable($request));

        $datatable['data'] = OrderStatusResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('order::clinic.order-statuses.create');
    }

    public function store(OrderStatusRequest $request)
    {
        try {
            $create = $this->orderStatus->create($request);

            if ($create) {
                return Response()->json([true , __('apps::clinic.messages.created')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('order::clinic.order-statuses.show');
    }

    public function edit($id)
    {
        $orderStatus = $this->orderStatus->findById($id);

        return view('order::clinic.order-statuses.edit',compact('orderStatus'));
    }

    public function update(OrderStatusRequest $request, $id)
    {
        try {
            $update = $this->orderStatus->update($request,$id);

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
            $delete = $this->orderStatus->delete($id);

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
            $deleteSelected = $this->orderStatus->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
