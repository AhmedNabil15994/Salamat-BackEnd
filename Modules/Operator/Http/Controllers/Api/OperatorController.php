<?php

namespace Modules\Operator\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Operator\Transformers\Api\OperatorResource;
use Modules\Operator\Repositories\Api\OperatorRepository as Operator;
use Modules\Apps\Http\Controllers\Api\ApiController;

class OperatorController extends ApiController
{

    function __construct(Operator $operator)
    {
        $this->operator = $operator;
    }

    public function list(Request $request)
    {
        $operators =  $this->operator->getAllOperatorsPaginate($request);

        return OperatorResource::collection($operators);
    }

    public function operator($id)
    {
        $operator = $this->operator->findById($id);

        if(!$operator)
          return $this->response([]);

        return $this->response(new OperatorResource($operator));
    }
}
