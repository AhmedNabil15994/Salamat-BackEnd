<?php

namespace Modules\Offer\Repositories\Dashboard;

use Modules\Offer\Entities\BookedOffer;
use DB;
use Auth;

class BookedOfferRepository
{
    function __construct(BookedOffer $offer)
    {
        $this->offer   = $offer;
    }

    public function monthlyOffers()
    {
        $data["offers_dates"] = $this->offer->whereHas('offerStatus', function($query) {
                                    $query->successPayment();
                                })
                                ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as dates"))
                                ->groupBy('dates')
                                ->pluck('dates');

        $offersIncome = $this->offer->whereHas('offerStatus', function($query) {
                            $query->successPayment();
                        })
                        ->select(\DB::raw("sum(total) as profit"))
                        ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->get();

        $data["profits"] = json_encode(array_pluck($offersIncome, 'profit'));

        return $data;
    }

    public function offersType()
    {
        $offers = $this->offer
                    ->with('offerStatus')
                    ->select("offer_status_id", \DB::raw("count(id) as count"))
                    ->groupBy('offer_status_id')
                    ->get();


        foreach ($offers as $offer) {

            $status = $offer->offerStatus->translate(locale())->title;
            $offer->type = $status;

        }

        $data["offersCount"] = json_encode(array_pluck($offers, 'count'));
        $data["offersType"]  = json_encode(array_pluck($offers, 'type'));

        return $data;
    }

    public function completeOffers()
    {
        $offers = $this->offer->whereHas('offerStatus', function($query) {
            $query->successPayment();
        })->count();

        return $offers;
    }

    public function totalProfit()
    {
        return $this->offer->whereHas('offerStatus', function($query) {
            $query->successPayment();
        })->sum('total');
    }

    public function getAll($offer = 'id', $sort = 'desc')
    {
        $offers = $this->offer->offerBy($offer, $sort)->get();
        return $offers;
    }

    public function findById($id)
    {
        $offer = $this->offer->withDeleted()->find($id);

        return $offer;
    }

    public function updateUnread($id)
    {
        $offer = $this->findById($id);

        $offer->update([
          'unread'  => true,
        ]);
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
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
        $query = $this->offer->orderBy('id','DESC')->whereHas('offer', function($query) {
                      $query->where('deleted_at',null);
                 })->whereHas('user', function($query) {
                      $query->where('deleted_at',null);
                 })->where(function($query) use($request){
                      $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
                 });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
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

        if (isset($request['req']['worker_id']))
             $query->where('worker_id' , $request['req']['worker_id']);

        if (isset($request['req']['status_id']))
            $query->where('offer_status_id' , $request['req']['status_id']);
        return $query;
    }

}
