<?php

namespace Modules\Specialty\Repositories\Dashboard;

use Modules\Specialty\Entities\Specialty;
use Hash;
use DB;

class SpecialtyRepository
{

    function __construct(Specialty $specialty)
    {
        $this->specialty   = $specialty;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $specialties = $this->specialty->active()->orderBy($order, $sort)->get();
        return $specialties;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $specialties = $this->specialty->orderBy($order, $sort)->get();
        return $specialties;
    }

    public function findById($id)
    {
        $specialty = $this->specialty->withDeleted()->find($id);
        return $specialty;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

          $specialty = $this->specialty->create([
            'status'     => $request->status ? 1 : 0,
            'image'      => $image,
          ]);

          $this->translateTable($specialty,$request);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $specialty = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($specialty) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $specialty->image;

        try {

            $specialty->update([
              'status'        => $request->status ? 1 : 0,
              'image'         => $image,
            ]);

            $this->translateTable($specialty,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model,$request)
    {
        foreach ($request['title'] as $locale => $value) {
          $model->translateOrNew($locale)->title           = $value;
          $model->translateOrNew($locale)->slug            = slugfy($value);
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
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

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->specialty->where(function($query) use($request){

                      $query->where('id'                , 'like' , '%'. $request->input('search.value') .'%');

                      $query->orWhere( function( $query ) use($request){

                          $query->whereHas('translations' , function($query) use($request) {
                              $query->orWhere('title'     , 'like' , '%'. $request->input('search.value') .'%');
                              $query->orWhere('slug'      , 'like' , '%'. $request->input('search.value') .'%');
                          });

                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Specialtys by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}
