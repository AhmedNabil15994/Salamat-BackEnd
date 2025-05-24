<?php

namespace Modules\Room\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Room\Http\Requests\Dashboard\RoomRequest;
use Modules\Room\Transformers\Dashboard\RoomResource;
use Modules\Room\Repositories\Dashboard\RoomRepository as Room;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class RoomController extends Controller
{

    function __construct(Room $room , Role $role)
    {
        $this->role = $role;
        $this->room = $room;
    }

    public function index()
    {
        return view('room::dashboard.rooms.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->room->QueryTable($request));

        $datatable['data'] = RoomResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllRoomsRoles('id','asc');
        return view('room::dashboard.rooms.create',compact('roles'));
    }

    public function store(RoomRequest $request)
    {
        try {
            $create = $this->room->create($request);

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
        return view('room::dashboard.rooms.show');
    }

    public function edit($id)
    {
        $room = $this->room->findById($id);
        $roles = $this->role->getAllRoomsRoles('id','asc');

        return view('room::dashboard.rooms.edit',compact('room','roles'));
    }

    public function update(RoomRequest $request, $id)
    {
        try {
            $update = $this->room->update($request,$id);

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
            $delete = $this->room->delete($id);

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
            $deleteSelected = $this->room->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
