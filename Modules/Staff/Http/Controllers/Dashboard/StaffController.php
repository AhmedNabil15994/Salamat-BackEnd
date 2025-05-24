<?php

namespace Modules\Staff\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Staff\Http\Requests\Dashboard\StaffRequest;
use Modules\Staff\Transformers\Dashboard\StaffResource;
use Modules\Staff\Repositories\Dashboard\StaffRepository as Staff;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class StaffController extends Controller
{

    function __construct(Staff $staff , Role $role)
    {
        $this->role  = $role;
        $this->staff = $staff;
    }

    public function index()
    {
        return view('staff::dashboard.staffs.index');
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
        return view('staff::dashboard.staffs.create',compact('roles'));
    }

    public function store(StaffRequest $request)
    {
        try {
            $create = $this->staff->create($request);

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
        return view('staff::dashboard.staffs.show');
    }

    public function edit($id)
    {
        $staff = $this->staff->findById($id);
        $roles = $this->role->getAllStaffsRoles('id','asc');

        return view('staff::dashboard.staffs.edit',compact('staff','roles'));
    }

    public function update(StaffRequest $request, $id)
    {
        try {
            $update = $this->staff->update($request,$id);

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
            $delete = $this->staff->delete($id);

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
            $deleteSelected = $this->staff->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
