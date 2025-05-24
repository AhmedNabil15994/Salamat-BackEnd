<?php

namespace Modules\Coupon\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Coupon\Http\Requests\Clinic\CouponRequest;
use Modules\Coupon\Transformers\Clinic\CouponResource;
use Modules\Coupon\Repositories\Clinic\CouponRepository as Coupon;

class CouponController extends Controller
{

    function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function index()
    {
        return view('coupon::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->coupon->QueryTable($request));

        $datatable['data'] = CouponResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('coupon::clinic.create');
    }

    public function store(CouponRequest $request)
    {
        try {
            $create = $this->coupon->create($request);

            if ($create) {
                return Response()->json([true , __('apps::clinic.messages.created')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('coupon::clinic.show');
    }

    public function edit($id)
    {
        $coupon = $this->coupon->findById($id);

        return view('coupon::clinic.edit',compact('coupon'));
    }

    public function update(CouponRequest $request, $id)
    {
        try {
            $update = $this->coupon->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::clinic.messages.updated')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->coupon->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->coupon->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
