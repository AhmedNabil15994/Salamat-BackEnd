<?php

namespace Modules\Service\Repositories\Api;

use Modules\Service\Entities\Service;
use DB;

class ServiceRepository
{

    function __construct(Service $service)
    {
        $this->service   = $service;
    }

    public function getAllActivePaginate($request,$order = 'id', $sort = 'desc')
    {
        $services = $this->service->with([
                      'points',
                      'doctor.doctor' => function ($query){
                          $query->with([
                              'offTimes','offDates','offDays','offCustomDates','shift','profile','rates',
                              'upcomingOrders' => function ($query){
                                  $query->with([
                                      'transactions','orderStatus','rates'
                                  ]);
                              },
                          ]);
                      },
                      'operators' => function ($query){
                          $query->with(['upcomingOrders','offDates','offTimes','offDays','offCustomDates','shift']);
                      },
                      'rooms' => function ($query){
                          $query->with(['upcomingOrders','offDates','offTimes','offDays','offCustomDates','shift']);
                      },
                    ])->where('hidden',false)->active()->orderBy($order, $sort);

        if ($request['category_id'])
            $services->where('category_id',$request->category_id);

        if ($request['doctor_id']){
            $services->whereHas('doctor', function ($query) use ($request) {
                $query->where('doctor_id',$request->doctor_id);
            });
        }

        return $services->get();
    }

    public function findById($id)
    {
        $service = $this->service->with([
                      'points',
                      'doctor.doctor' => function ($query){
                          $query->with([
                              'offTimes','offDates','offDays','offCustomDates','shift','profile','rates',
                              'upcomingOrders' => function ($query){
                                  $query->with([
                                      'transactions','orderStatus','rates'
                                  ]);
                              },
                          ]);
                      },
                      'operators' => function ($query){
                          $query->with(['upcomingOrders','offDates','offTimes','offDays','offCustomDates','shift']);
                      },
                      'rooms' => function ($query){
                          $query->with(['upcomingOrders','offDates','offTimes','offDays','offCustomDates','shift']);
                      },
                    ])->active()->find($id);

        return $service;
    }

}
