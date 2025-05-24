<?php

namespace Modules\Clinic\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Clinic\Http\Requests\Dashboard\ClinicRequest;
use Modules\Clinic\Transformers\Dashboard\ClinicResource;
use Modules\Clinic\Repositories\Dashboard\ClinicRepository as Clinic;

class ClinicController extends Controller
{
    public function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
    }

    public function sorting()
    {
        $clinics = $this->clinic->getAll('sorting', 'ASC');
        return view('clinic::dashboard.sorting', compact('clinics'));
    }

    public function storeSorting(Request $request)
    {
        $create = $this->clinic->sorting($request);

        if ($create) {
            return Response()->json([true , __('apps::dashboard.messages.created')]);
        }

        return Response()->json([true , __('apps::dashboard.messages.failed')]);
    }

    public function detailsByClinicId(Request $request)
    {
        $clinic = $this->clinic->findDetailsByClinicId($request['clinic_id']);

        return view('service::dashboard.tabs.details', compact('clinic'));
    }

    public function doctorsByClinicId(Request $request)
    {
        $clinic = $this->clinic->findDoctorByClinicId($request['clinic_id']);

        return view('doctor::dashboard.doctors.tabs.doctors', compact('clinic'));
    }

    public function doctorsByClinicId2(Request $request)
    {
        $clinic = $this->clinic->findDoctorByClinicId($request['clinic_id']);
        $users = $this->clinic->getClinicUsers($request['clinic_id']);

        return view('doctor::dashboard.doctors.tabs.doctors2', compact('clinic', 'users'));
    }

    public function servicesByClinicId(Request $request)
    {
        $clinic = $this->clinic->findServicesByClinicId($request['clinic_id']);

        return view('service::dashboard.tabs.services', compact('clinic'));
    }

    public function index()
    {
        return view('clinic::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->clinic->QueryTable($request));

        $datatable['data'] = ClinicResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('clinic::dashboard.create');
    }

    public function store(ClinicRequest $request)
    {
        try {
            $create = $this->clinic->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('clinic::dashboard.show');
    }

    public function edit($id)
    {
        $clinic = $this->clinic->findById($id);

        return view('clinic::dashboard.edit', compact('clinic'));
    }

    public function update(ClinicRequest $request, $id)
    {
        try {
            $update = $this->clinic->update($request, $id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->clinic->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->clinic->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
