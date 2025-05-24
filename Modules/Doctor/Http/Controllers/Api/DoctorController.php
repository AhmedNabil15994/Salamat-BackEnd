<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Doctor\Transformers\Api\DoctorResource;
use Modules\Doctor\Repositories\Api\DoctorRepository as Doctor;
use Modules\Apps\Http\Controllers\Api\ApiController;

class DoctorController extends ApiController
{

    function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function list(Request $request)
    {
        $doctors =  $this->doctor->getAllDoctorsPaginate($request);

        return DoctorResource::collection($doctors);
    }

    public function doctor($id)
    {
        $doctor = $this->doctor->findById($id);

        if(!$doctor)
          return $this->response([]);

        return $this->response(new DoctorResource($doctor));
    }
}
