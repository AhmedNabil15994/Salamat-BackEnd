<?php

namespace Modules\Blog\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Blog\Http\Requests\Clinic\BlogRequest;
use Modules\Blog\Transformers\Clinic\BlogResource;
use Modules\Blog\Repositories\Clinic\BlogRepository as Blog;
use ClinicFacade;

class BlogController extends Controller
{

    function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function index()
    {
        return view('blog::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->blog->QueryTable($request));

        $datatable['data'] = BlogResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('blog::clinic.create');
    }

    public function store(BlogRequest $request)
    {
        try {

            if (ClinicFacade::blogs_limit() >= count(ClinicFacade::data()->blogs)) {

                $create = $this->blog->create($request);

                if ($create) {
                    return Response()->json([true , __('apps::clinic.messages.created')]);
                }

                return Response()->json([false , __('apps::clinic.messages.failed')]);

            }else{
                return Response()->json([false , __('blog::clinic.messages.reached_limitation')]);
            }

        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('blog::clinic.show');
    }

    public function edit($id)
    {
        $blog = $this->blog->findById($id);

        return view('blog::clinic.edit',compact('blog'));
    }

    public function update(BlogRequest $request, $id)
    {
        try {
            $update = $this->blog->update($request,$id);

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
            $delete = $this->blog->delete($id);

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
            $deleteSelected = $this->blog->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
