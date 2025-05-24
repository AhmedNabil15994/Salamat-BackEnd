<?php

namespace Modules\Doctor\Repositories\Api;

use Modules\Doctor\Entities\Doctor;
use Hash;
use DB;

class DoctorRepository
{

    function __construct(Doctor $doctor)
    {
        $this->doctor      = $doctor;
    }

    public function getAllDoctorsPaginate($request)
    {
        $doctors = $this->doctor->with([
            'gallery','socialMedia','contacts','specialties','blogs','profile','rates',
            'clinic.clinic' => function ($query){
                $query->where('status',true)->with([
                    'branches.state.city','shift','translations','shift','offDays',
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
                ]);
            }
        ])->whereHas('clinic.clinic', function($query) use($request){
            $query->where('status',true);
         })->whereHas('roles.perms', function($query){
            $query->where('name','doctor_access');
        })->orderBy('sorting_doctor', 'ASC');


        if ($request['specialties_id']) {
            $doctors->whereHas('specialties', function($query) use($request){
                $query->whereIn('specialty_id',$request['specialties_id']);
             });
        }

        if ($request['search_key']) {

            $doctors->whereHas('profile.translations', function($query) use($request){
                $query->where('name'            , 'like' , '%'. $request->input('search_key') .'%');
                $query->orWhere('job_title'     , 'like' , '%'. $request->input('search_key') .'%');
                $query->orWhere('about'         , 'like' , '%'. $request->input('search_key') .'%');
           });

        }

        if ($request['clinic_id']) {
            $doctors->whereHas('clinic', function($query) use($request){
                $query->where('clinic_id',$request['clinic_id']);
             });
        }

        if ($request['state_id']) {
            $doctors->whereHas('clinic.clinic.branches', function($query) use($request){
               $query->where('state_id',$request['state_id']);
           });
        }

        return $doctors->paginate(24);
    }

    public function findById($id)
    {
        $doctor = $this->doctor->where('id',$id)->with([
            'gallery','socialMedia','contacts','specialties','blogs','offTimes','offDates','offDays','offCustomDates','shift','upcomingOrders','profile','rates',
            'clinic.clinic' => function ($query){
                $query->with(['branches.state.city','offers.services']);
            }
        ])->whereHas('roles.perms', function($query){
            $query->where('name','doctor_access');
        })->first();

        return $doctor;
    }
}
