<?php

namespace Modules\Blog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Blog\Transformers\Api\BlogResource;
use Modules\Blog\Repositories\Api\BlogRepository as Blog;
use Modules\Apps\Http\Controllers\Api\ApiController;

class BlogController extends ApiController
{

    function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function blogs(Request $request)
    {
        $blogs =  $this->blog->getAllActivePaginate($request);

        return BlogResource::collection($blogs);
    }

    public function blog($id)
    {
        $blog = $this->blog->findById($id);

        if(!$blog)
          return $this->response([]);

        return $this->response(new BlogResource($blog));
    }
}
