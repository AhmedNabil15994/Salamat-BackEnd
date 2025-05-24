<?php

namespace Modules\Operator\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Operator\Http\Requests\Dashboard\OperatorRequest;
use Modules\Operator\Transformers\Dashboard\OperatorResource;
use Modules\Operator\Repositories\Dashboard\OperatorRepository as Operator;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class OperatorController extends Controller
{

    function __construct(Operator $operator , Role $role)
    {
        $this->role     = $role;
        $this->operator = $operator;
    }

    public function index()
    {
        return view('operator::dashboard.operators.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->operator->QueryTable($request));

        $datatable['data'] = OperatorResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllOperatorsRoles('id','asc');
        return view('operator::dashboard.operators.create',compact('roles'));
    }

    public function store(OperatorRequest $request)
    {
        try {
            $create = $this->operator->create($request);

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
        return view('operator::dashboard.operators.show');
    }

    public function edit($id)
    {
        $operator = $this->operator->findById($id);
        $roles = $this->role->getAllOperatorsRoles('id','asc');

        return view('operator::dashboard.operators.edit',compact('operator','roles'));
    }

    public function update(OperatorRequest $request, $id)
    {
        try {
            $update = $this->operator->update($request,$id);

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
            $delete = $this->operator->delete($id);

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
            $deleteSelected = $this->operator->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
