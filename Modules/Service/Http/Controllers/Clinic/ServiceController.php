<?php

namespace Modules\Service\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Service\Http\Requests\Clinic\ServiceRequest;
use Modules\Service\Transformers\Clinic\ServiceResource;
use Modules\Service\Repositories\Clinic\ServiceRepository as Service;
use Modules\Clinic\Repositories\Clinic\ClinicRepository as Clinic;

class ServiceController extends Controller
{

    function __construct(Service $service,Clinic $clinic)
    {
        $this->service = $service;
        $this->clinic  = $clinic;
    }

    public function index()
    {
        return view('service::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->service->QueryTable($request));

        $datatable['data'] = ServiceResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('service::clinic.create');
    }

    public function store(ServiceRequest $request)
    {
        try {
            $create = $this->service->create($request);

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
        return view('service::clinic.show');
    }

    public function edit($id)
    {
        $service = $this->service->findById($id);

        $clinic = $this->clinic->findDetailsByClinicId($service['clinic_id']);

        return view('service::clinic.edit',compact('service','clinic'));
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $update = $this->service->update($request,$id);

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
            $delete = $this->service->delete($id);

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
            $deleteSelected = $this->service->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
