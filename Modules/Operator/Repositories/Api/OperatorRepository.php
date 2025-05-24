<?php

namespace Modules\Operator\Repositories\Api;

use Modules\Operator\Entities\Operator;
use Hash;
use DB;

class OperatorRepository
{

    function __construct(Operator $operator)
    {
        $this->operator      = $operator;
    }

    public function getAllOperatorsPaginate($request)
    {
        $operators = $this->operator->whereHas('roles.perms', function($query){
                       $query->where('name','operator_access');
                    })->orderBy('id', 'desc');

        if ($request['clinic_id']) {
            $operators->whereHas('pivotClinic', function($query) use($request){
                $query->where('clinic_id',$request['clinic_id']);
             });
        }

        return $operators->paginate(24);
    }

    public function findById($id)
    {
        $operator = $this->operator->where('id',$id)->whereHas('roles.perms', function($query){
                     $query->where('name','operator_access');
                  })->first();

        return $operator;
    }
}
