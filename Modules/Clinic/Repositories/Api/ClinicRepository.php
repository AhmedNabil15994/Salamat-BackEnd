<?php

namespace Modules\Clinic\Repositories\Api;

use Modules\Clinic\Entities\Clinic;

class ClinicRepository
{
    function __construct(Clinic $clinic)
    {
        $this->clinic   = $clinic;
    }

    public function getAllActivePaginate($request)
    {
        $clinics = $this->clinic->active()->with([
            'blogs','contacts','gallery','socialMedia','blogs','branches.state.city','shift','translations','shift','offDays',
            'offers' => function ($query){
                $query->active()->with([
                    'services' => function ($query) {
                      $query->where('hidden',false)->active()->with([
                          'points',
                          'doctor.doctor' => function ($query){
                              $query->with([
                                  'upcomingOrders','offTimes','offDates','offDays','offCustomDates','shift','profile','rates'
                              ]);
                          },

                      ]);
                    },
                ]);
            },
            'doctors' => function ($query){
                $query->with([
                    'gallery','socialMedia','contacts','specialties','blogs','profile','rates'
                ]);
            }
        ]);

        if ($request['specialties_id']) {
            $clinics->whereHas('doctors.specialties', function($query) use($request){
                $query->whereIn('specialty_id',$request['specialties_id']);
           });
        }

        if ($request['state_id']) {
            $clinics->whereHas('branches', function($query) use($request){
               $query->where('state_id',$request['state_id']);
           });
        }

        if ($request['search_key']) {
            $clinics->whereHas('translations', function($query) use($request){
                $query->where('description'   , 'like' , '%'. $request->input('search_key') .'%');
                $query->orWhere('title'       , 'like' , '%'. $request->input('search_key') .'%');
                $query->orWhere('slug'        , 'like' , '%'. $request->input('search_key') .'%');
           });
        }

        return $clinics->orderBy('sorting', 'ASC')->paginate(24);
    }

    public function findById($id)
    {
        $clinic = $this->clinic->active()->with([
            'blogs','contacts','gallery','socialMedia','blogs','branches.state.city','shift','translations',
            'offers' => function ($query){
                $query->active()->with([
                    'services' => function ($query) {
                      $query->where('hidden',false)->active()->with([
                          'points',
                          'doctor.doctor' => function ($query){
                              $query->with([
                                  'upcomingOrders','offTimes','offDates','offDays','offCustomDates','shift','profile','rates'
                              ]);
                          },

                      ]);
                    },
                ]);
            },
            'doctors' => function ($query){
                $query->with([
                    'gallery','socialMedia','contacts','specialties','blogs','profile','rates'
                ]);
            }
        ])->where('id',$id)->first();

        return $clinic;
    }
}
