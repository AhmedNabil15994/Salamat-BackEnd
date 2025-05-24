<?php

namespace Modules\Category\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Category\Http\Requests\Clinic\CategoryRequest;
use Modules\Category\Transformers\Clinic\CategoryResource;
use Modules\Category\Repositories\Clinic\CategoryRepository as Category;

class CategoryController extends Controller
{

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function sorting()
    {
        $categories = $this->category->getAllGroupByClinic('sorting','ASC');
        return view('category::clinic.sorting',compact('categories'));
    }

    public function storeSorting(Request $request)
    {
        $create = $this->category->sorting($request);

        if ($create) {
            return Response()->json([true , __('apps::clinic.messages.created')]);
        }

        return Response()->json([true , __('apps::clinic.messages.failed')]);
    }

    public function index()
    {
        return view('category::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->category->QueryTable($request));

        $datatable['data'] = CategoryResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('category::clinic.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $create = $this->category->create($request);

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
        return view('category::clinic.show');
    }

    public function edit($id)
    {
        $category = $this->category->findById($id);

        return view('category::clinic.edit',compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $update = $this->category->update($request,$id);

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
            $delete = $this->category->delete($id);

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
            $deleteSelected = $this->category->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
