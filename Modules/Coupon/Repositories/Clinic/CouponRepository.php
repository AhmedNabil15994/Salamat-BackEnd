<?php

namespace Modules\Coupon\Repositories\Clinic;

use Modules\Coupon\Entities\Coupon;
use ClinicFacade;
use DB;

class CouponRepository
{

    function __construct(Coupon $coupon)
    {
        $this->coupon   = $coupon;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $coupons = $this->coupon->active()->orderBy($order, $sort)->get();
        return $coupons;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $coupons = $this->coupon->orderBy($order, $sort)->get();
        return $coupons;
    }

    public function findById($id)
    {
        $coupon = $this->coupon->find($id);
        return $coupon;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $coupon = $this->coupon->create([
              'code'              => $request->code,
              'discount'          => $request->discount,
              'used_times'        => $request->used_times,
              'from'              => $request->from,
              'to'                => $request->to,
              'clinic_id'         => ClinicFacade::id(),
              'status'            => $request->status ? 1 : 0,
            ]);

            $coupon->users()->sync($request['user_id']);
            $coupon->services()->sync($request['service_id']);

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

        $coupon = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($coupon) : null;

        try {

            $coupon->update([
              'code'              => $request->code,
              'discount'          => $request->discount,
              'used_times'        => $request->used_times,
              'from'              => $request->from,
              'to'                => $request->to,
              'clinic_id'         => ClinicFacade::id(),
              'status'            => $request->status ? 1 : 0,
            ]);

            $coupon->users()->sync($request['user_id']);
            $coupon->services()->sync($request['service_id']);

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
        $query = $this->coupon->where('clinic_id',ClinicFacade::id())->where(function($query) use($request){
                      $query->where('id'                 , 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere('code'             , 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere('discount'         , 'like' , '%'. $request->input('search.value') .'%');
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
