<?php

namespace Modules\Specialty\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Specialty\Transformers\Api\SpecialtyResource;
use Modules\Specialty\Repositories\Api\SpecialtyRepository as Specialty;
use Modules\Apps\Http\Controllers\Api\ApiController;

class SpecialtyController extends ApiController
{

    function __construct(Specialty $specialty)
    {
        $this->specialty = $specialty;
    }


    public function all(Request $request)
    {
        $specialties = $this->specialty->getAllActivePaginate($request);

        return SpecialtyResource::collection($specialties);
    }

    public function show($id)
    {
        $specialty = $this->specialty->findById($id);

        if(!$specialty)
          return $this->response([]);

        return $this->response(new SpecialtyResource($specialty));

    }
}
