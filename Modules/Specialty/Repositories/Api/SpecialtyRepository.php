<?php

namespace Modules\Specialty\Repositories\Api;

use Modules\Specialty\Entities\Specialty;
use DB;

class SpecialtyRepository
{

    function __construct(Specialty $specialty)
    {
        $this->specialty   = $specialty;
    }

    public function getAllActivePaginate($request,$order = 'id', $sort = 'desc')
    {
        $specialties = $this->specialty->with([
          'doctors' => function ($query){
              $query->with(['profile']);
          }
        ])->active();

        if ($request['clinic_id']) {

            $specialties->whereHas('doctors.clinic', function($query) use($request){
               $query->where('clinic_id',$request['clinic_id']);
           });

        }

        return $specialties->orderBy($order, $sort)->paginate(24);;
    }

    public function findById($id)
    {
        $specialty = $this->specialty->with([
          'doctors' => function ($query){
              $query->with(['profile']);
          }
        ])->active()->where('id',$id)->first();
        
        return $specialty;
    }
}
