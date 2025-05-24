<?php

namespace Modules\Blog\Repositories\Api;

use Modules\Doctor\Entities\Doctor;
use Modules\Clinic\Entities\Clinic;
use Modules\Blog\Entities\Blog;
use DB;

class BlogRepository
{
    function __construct(Blog $blog,Doctor $doctor , Clinic $clinic)
    {
        $this->clinic   = $clinic;
        $this->doctor   = $doctor;
        $this->blog     = $blog;
    }

    public function getAllActivePaginate($request,$order = 'id', $sort = 'desc')
    {

        $blogs = $this->blog->active()->orderBy($order, $sort);

        if ($request['clinic_id']){

            $blogs->whereHas('clinics', function ($query) use ($request) {
                $query->where([
                    'blogable_id' => $request->clinic_id
                ]);
            });

        }

        if ($request['doctor_id']){

            $blogs->whereHas('doctors', function ($query) use ($request) {
                $query->where([
                    'blogable_id' => $request->doctor_id
                ]);
              });
        }

        return $blogs->paginate(24);
    }

    public function findById($id)
    {
        $blog = $this->blog->find($id);
        return $blog;
    }

}
