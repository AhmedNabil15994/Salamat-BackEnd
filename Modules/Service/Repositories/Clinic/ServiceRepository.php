<?php

namespace Modules\Service\Repositories\Clinic;

use Modules\Service\Entities\Service;
use ClinicFacade;
use DB;

class ServiceRepository
{

    function __construct(Service $service)
    {
        $this->service   = $service;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $services = $this->service->where('clinic_id',ClinicFacade::id())->active()->orderBy($order, $sort)->get();
        return $services;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $services = $this->service->where('clinic_id',ClinicFacade::id())->orderBy($order, $sort)->get();
        return $services;
    }

    public function findById($id)
    {
        $service = $this->service->where('clinic_id',ClinicFacade::id())->withDeleted()->find($id);
        return $service;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

          $service = $this->service->create([
            'clinic_id'             => ClinicFacade::id(),
            'ignore_doctor'         => $request->ignore_doctor ? 1 : 0,
            'category_id'           => $request->clinic_category_id,
            'price'                 => $request->price,
            'status'                => $request->status ? 1 : 0,
            'hidden'                => $request->hidden ? 1 : 0,
            'is_consultation'       => $request->is_consultation ? 1 : 0,
            'image'                 => $image,
            'service_take_time'     => $request->time_to_take,
          ]);

          $service->doctor()->create([
            'doctor_id' => $request['doctor_id']
          ]);

          if ( ($request['point_amount'] > 0) ) {
              $service->points()->create([
                  'amount'              => $request['point_amount'],
                  'points_per_amount'   => $request['points_per_amount'],
                  'status'              => true,
              ]);
          }

          $service->rooms()->sync($request['room_id']);
          $service->operators()->sync($request['operator_id']);

          $this->translateTable($service,$request);

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

        $service = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($service) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $service->image;

        try {

            $service->update([
              'clinic_id'         => ClinicFacade::id(),
              'ignore_doctor'     => $request->ignore_doctor ? 1 : 0,
              'category_id'       => $request->clinic_category_id,
              'price'             => $request->price,
              'status'            => $request->status ? 1 : 0,
              'hidden'            => $request->hidden ? 1 : 0,
              'is_consultation'   => $request->is_consultation ? 1 : 0,
              'image'             => $image,
              'service_take_time' => $request->time_to_take,
            ]);

            $service->doctor()->updateOrCreate(
            [
              'service_id'  => $service['id']
            ],
            [
              'doctor_id' => $request['doctor_id']
            ]);

            if ( ($request['point_amount'] > 0) ) {
                $service->points()->updateOrCreate(
                [
                    'service_id'  => $service['id']
                ],
                [
                    'amount'              => $request['point_amount'],
                    'points_per_amount'   => $request['points_per_amount'],
                    'status'              => true,
                ]);
            }else{
                $service->points()->delete();
            }

            $service->rooms()->sync($request['room_id']);
            $service->operators()->sync($request['operator_id']);

            $this->translateTable($service,$request);

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
          $model->translateOrNew($locale)->description     = $request['description'][$locale];
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
        $query = $this->service->where('clinic_id',ClinicFacade::id())->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('description'        , 'like' , '%'. $request->input('search.value') .'%');
                              $query->orWhere('title'            , 'like' , '%'. $request->input('search.value') .'%');
                              $query->orWhere('slug'             , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Services by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        return $query;
    }

}
