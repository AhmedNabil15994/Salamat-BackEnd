<?php

namespace Modules\Doctor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Doctor\Http\Requests\Dashboard\DoctorRequest;
use Modules\Doctor\Transformers\Dashboard\DoctorResource;
use Modules\Doctor\Repositories\Dashboard\DoctorRepository as Doctor;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class DoctorController extends Controller
{
    public function __construct(Doctor $doctor, Role $role)
    {
        $this->role   = $role;
        $this->doctor = $doctor;
    }

    public function sorting()
    {
        $doctors = $this->doctor->getAllDoctors('sorting_doctor', 'ASC');
        return view('doctor::dashboard.doctors.sorting', compact('doctors'));
    }

    public function storeSorting(Request $request)
    {
        $create = $this->doctor->sorting($request);

        if ($create) {
            return Response()->json([true , __('apps::dashboard.messages.created')]);
        }

        return Response()->json([true , __('apps::dashboard.messages.failed')]);
    }

    public function index()
    {
        return view('doctor::dashboard.doctors.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->doctor->QueryTable($request));

        $datatable['data'] = DoctorResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllDoctorsRoles('id', 'asc');
        return view('doctor::dashboard.doctors.create', compact('roles'));
    }

    public function store(DoctorRequest $request)
    {
        try {
            $create = $this->doctor->create($request);

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
        abort(404);
        return view('doctor::dashboard.doctors.show');
    }

    public function edit($id)
    {
        $doctor = $this->doctor->findById($id);
        $roles = $this->role->getAllDoctorsRoles('id', 'asc');

        return view('doctor::dashboard.doctors.edit', compact('doctor', 'roles'));
    }

    public function update(DoctorRequest $request, $id)
    {
        try {
            $update = $this->doctor->update($request, $id);

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
            $delete = $this->doctor->delete($id);

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
            $deleteSelected = $this->doctor->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
