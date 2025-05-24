<?php

namespace Modules\Specialty\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Specialty\Http\Requests\Dashboard\SpecialtyRequest;
use Modules\Specialty\Transformers\Dashboard\SpecialtyResource;
use Modules\Specialty\Repositories\Dashboard\SpecialtyRepository as Specialty;

class SpecialtyController extends Controller
{

    function __construct(Specialty $specialty)
    {
        $this->specialty = $specialty;
    }

    public function index()
    {
        return view('specialty::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->specialty->QueryTable($request));

        $datatable['data'] = SpecialtyResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('specialty::dashboard.create');
    }

    public function store(SpecialtyRequest $request)
    {
        try {
            $create = $this->specialty->create($request);

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
        return view('specialty::dashboard.show');
    }

    public function edit($id)
    {
        $specialty = $this->specialty->findById($id);

        return view('specialty::dashboard.edit',compact('specialty'));
    }

    public function update(SpecialtyRequest $request, $id)
    {
        try {
            $update = $this->specialty->update($request,$id);

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
            $delete = $this->specialty->delete($id);

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
            $deleteSelected = $this->specialty->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
