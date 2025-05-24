<?php

namespace Modules\Clinic\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Clinic\Http\Requests\Clinic\ClinicRequest;
use Modules\Clinic\Transformers\Clinic\ClinicResource;
use Modules\Clinic\Repositories\Clinic\ClinicRepository as Clinic;

class ClinicController extends Controller
{

    function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
    }

    public function doctorsByClinicId(Request $request)
    {
        $clinic = $this->clinic->findDoctorByClinicId($request['clinic_id']);

        return view('doctor::clinic.doctors.tabs.doctors',compact('clinic'));
    }
    
    public function index()
    {
        return view('clinic::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->clinic->QueryTable($request));

        $datatable['data'] = ClinicResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('clinic::clinic.create');
    }

    public function store(ClinicRequest $request)
    {
        try {
            $create = $this->clinic->create($request);

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
        return view('clinic::clinic.show');
    }

    public function edit($id)
    {
        $clinic = $this->clinic->findById($id);

        return view('clinic::clinic.edit',compact('clinic'));
    }

    public function update(ClinicRequest $request, $id)
    {
        try {
            $update = $this->clinic->update($request,$id);

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
            $delete = $this->clinic->delete($id);

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
            $deleteSelected = $this->clinic->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
