<?php

namespace Modules\Staff\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Staff\Http\Requests\Clinic\StaffRequest;
use Modules\Staff\Transformers\Clinic\StaffResource;
use Modules\Staff\Repositories\Clinic\StaffRepository as Staff;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class StaffController extends Controller
{

    function __construct(Staff $staff , Role $role)
    {
        $this->role     = $role;
        $this->staff = $staff;
    }

    public function index()
    {
        return view('staff::clinic.staffs.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->staff->QueryTable($request));

        $datatable['data'] = StaffResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllStaffsRoles('id','asc');
        return view('staff::clinic.staffs.create',compact('roles'));
    }

    public function store(StaffRequest $request)
    {
        try {
            $create = $this->staff->create($request);

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
        abort(404);
        return view('staff::clinic.staffs.show');
    }

    public function edit($id)
    {
        $staff = $this->staff->findById($id);
        $roles = $this->role->getAllStaffsRoles('id','asc');

        return view('staff::clinic.staffs.edit',compact('staff','roles'));
    }

    public function update(StaffRequest $request, $id)
    {
        try {
            $update = $this->staff->update($request,$id);

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
            $delete = $this->staff->delete($id);

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
            $deleteSelected = $this->staff->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
