<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Category\Transformers\Api\CategoryResource;
use Modules\Category\Repositories\Api\CategoryRepository as Category;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
{

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function categories(Request $request)
    {
        $categories =  $this->category->getAllActivePaginate($request);

        return CategoryResource::collection($categories);
    }

    public function category($id)
    {
        $category = $this->category->findById($id);

        if(!$category)
          return $this->response([]);

        return $this->response(new CategoryResource($category));
    }
}
