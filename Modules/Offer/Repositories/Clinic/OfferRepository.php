<?php

namespace Modules\Offer\Repositories\Clinic;

use Modules\Offer\Entities\Offer;
use ClinicFacade;
use DB;

class OfferRepository
{

    function __construct(Offer $offer)
    {
        $this->offer   = $offer;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $offers = $this->offer->active()->orderBy($order, $sort)->get();
        return $offers;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $offers = $this->offer->orderBy($order, $sort)->get();
        return $offers;
    }

    public function findById($id)
    {
        $offer = $this->offer->withTrashed()->find($id);
        return $offer;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

            $offer = $this->offer->create([
              'price'             => $request->price,
              'clinic_id'         => ClinicFacade::id(),
              'status'            => $request->status ? 1 : 0,
              'image'             => $image,
            ]);

            $offer->services()->sync($request['service_id']);

            $this->translateTable($offer,$request);

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

        $offer = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($offer) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $offer->image;

        try {

            $offer->update([
              'price'             => $request->price,
              'clinic_id'         => ClinicFacade::id(),
              'status'            => $request->status ? 1 : 0,
              'image'             => $image,
            ]);

            $offer->services()->sync($request['service_id']);

            $this->translateTable($offer,$request);

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
            $model->translateOrNew($locale)->description     = $request['title'][$locale];
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
        $query = $this->offer->whereHas('clinic', function($query){
                        $query->where('id',ClinicFacade::id());
                    })->where(function($query) use($request){
                          $query->where('id'              , 'like' , '%'. $request->input('search.value') .'%');
                          $query->orWhere('price'         , 'like' , '%'. $request->input('search.value') .'%');
                    });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Categories by Created Dates
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
