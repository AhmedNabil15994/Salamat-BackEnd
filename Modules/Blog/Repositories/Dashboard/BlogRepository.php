<?php

namespace Modules\Blog\Repositories\Dashboard;

use Modules\Doctor\Entities\Doctor;
use Modules\Clinic\Entities\Clinic;
use Modules\Blog\Entities\Blog;
use DB;

class BlogRepository
{
    public function __construct(Blog $blog, Doctor $doctor, Clinic $clinic)
    {
        $this->clinic   = $clinic;
        $this->doctor   = $doctor;
        $this->blog     = $blog;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $blogs = $this->blog->active()->orderBy($order, $sort)->get();
        return $blogs;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $blogs = $this->blog->orderBy($order, $sort)->get();
        return $blogs;
    }

    public function findById($id)
    {
        $blog = $this->blog->withDeleted()->find($id);
        return $blog;
    }

    public function create($request)
    {
        if ($request['doctor_id']) {
            $model    = $this->doctor->find($request['doctor_id']);
        }

        if ($request['clinic_id']) {
            $model = $this->clinic->find($request['clinic_id']);
        }

        DB::beginTransaction();

        try {
            $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

            $blog = $model->blogs()->create([
            'status'   => $request->status ? 1 : 0,
            'video'    => $request->video ,
            'image'    => $image,
            ]);

            $this->translateTable($blog, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $blog = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($blog) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $blog->image;

        try {
            $blog->update([
                'blogable_type'  => isset($request['doctor_id'])
                    ? 'Modules\Doctor\Entities\Doctor'
                    : 'Modules\Clinic\Entities\Clinic',
                'blogable_id'  => isset($request['doctor_id'])
                    ? $request['doctor_id']
                    : $request['clinic_id'],
                'video'    => $request->video ,
                'status'   => $request->status ? 1 : 0,
                'image'    => $image
            ]);

            $this->translateTable($blog, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
            $model->translateOrNew($locale)->slug            = slugfy($value);
            $model->translateOrNew($locale)->description     = $request['description'][$locale];
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

                DB::commit();
                return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->blog->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Blogs by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }


        if (isset($request['req']['clinics'])) {
            $query->whereHas('clinics', function ($query) use ($request) {
                $query->where('id', $request['req']['clinics']);
            });
        }

        return $query;
    }
}
