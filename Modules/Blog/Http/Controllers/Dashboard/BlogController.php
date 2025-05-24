<?php

namespace Modules\Blog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Blog\Http\Requests\Dashboard\BlogRequest;
use Modules\Blog\Transformers\Dashboard\BlogResource;
use Modules\Blog\Repositories\Dashboard\BlogRepository as Blog;

class BlogController extends Controller
{
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function index()
    {
        return view('blog::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->blog->QueryTable($request));

        $datatable['data'] = BlogResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('blog::dashboard.create');
    }

    public function store(BlogRequest $request)
    {
        try {
            $create = $this->blog->create($request);

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
        return view('blog::dashboard.show');
    }

    public function edit($id)
    {
        $blog = $this->blog->findById($id);

        return view('blog::dashboard.edit', compact('blog'));
    }

    public function update(BlogRequest $request, $id)
    {
        try {
            $update = $this->blog->update($request, $id);

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
            $delete = $this->blog->delete($id);

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
            $deleteSelected = $this->blog->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
