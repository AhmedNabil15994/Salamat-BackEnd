<?php

namespace Modules\Service\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Service\Transformers\Api\ServiceResource;
use Modules\Service\Repositories\Api\ServiceRepository as Service;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Operator\Transformers\Api\OperatorResource;
use Modules\Doctor\Transformers\Api\DoctorResource;
use Modules\Room\Transformers\Api\RoomResource;
use Modules\Availability\Traits\ShiftTrait;
use Carbon\Carbon;

class ServiceController extends ApiController
{
    use ShiftTrait;

    function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function services(Request $request)
    {
        $services =  $this->service->getAllActivePaginate($request);

        return ServiceResource::collection($services);
    }

    public function times($id)
    {
        $service = $this->service->findById($id);

        $objectTime = ($service->ignore_doctor == true) ? $service->clinic : $service->doctor->doctor;

        $operators = ($service->ignore_doctor == true) ? OperatorResource::collection($service->operators) : [];
        $doctor    = ($service->ignore_doctor == true) ? [] : new DoctorResource($service->doctor->doctor);
        $rooms     = ($service->ignore_doctor == true) ? RoomResource::collection($service->rooms) : [];
        $times     = $this->availabiltyTimes($objectTime,$service->service_take_time);

        $data = [
            'timezone'  => Carbon::createFromTime(date('H'), date('i'), date('s'), 'Europe/London'),
            // 'timezone'  => date('Y-m-d H:i:s'),
            // 'timezone'  => Carbon::now('Asia/Kuwait'),
            'times'     => $times,
            'doctor'    => $doctor,
            'operators' => $operators,
            'rooms'     => $rooms
        ];

        return $this->response($data);
    }

    public function service($id)
    {
        $service = $this->service->findById($id);

        if(!$service)
          return $this->response([]);

        return $this->response(new ServiceResource($service));
    }
}
