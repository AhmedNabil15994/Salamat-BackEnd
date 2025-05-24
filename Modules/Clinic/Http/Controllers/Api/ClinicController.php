<?php

namespace Modules\Clinic\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Clinic\Transformers\Api\ClinicResource;
use Modules\Clinic\Repositories\Api\ClinicRepository as Clinic;
use Modules\Apps\Http\Controllers\Api\ApiController;

class ClinicController extends ApiController
{

    function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
    }

    public function clinics(Request $request)
    {
        $clinics =  $this->clinic->getAllActivePaginate($request);

        return ClinicResource::collection($clinics);
    }

    public function clinic($id)
    {
        $clinic = $this->clinic->findById($id);

        if(!$clinic)
          return $this->response([]);

        return $this->response(new ClinicResource($clinic));
    }
}
