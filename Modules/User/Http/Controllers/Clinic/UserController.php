<?php

namespace Modules\User\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Clinic\UserRequest;
use Modules\User\Transformers\Clinic\UserResource;
use Modules\User\Repositories\Clinic\UserRepository as User;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class UserController extends Controller
{

    function __construct(User $user , Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        return view('user::clinic.users.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));

        $datatable['data'] = UserResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAll('id','asc');
        return view('user::clinic.users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $create = $this->user->create($request);

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
        abort_if((int) $id !== auth()->id(), 403);

        abort(404);
        return view('user::clinic.users.show');
    }

    public function edit($id)
    {
        abort_if((int) $id !== auth()->id(), 403);

        $user = $this->user->findById($id);
        $roles = $this->role->getAll('id','asc');

        return view('user::clinic.users.edit',compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        abort_if((int) $id !== auth()->id(), 403);

        try {
            $update = $this->user->update($request,$id);

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
        abort_if((int) $id !== auth()->id(), 403);

        try {
            $delete = $this->user->delete($id);

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
            $deleteSelected = $this->user->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
