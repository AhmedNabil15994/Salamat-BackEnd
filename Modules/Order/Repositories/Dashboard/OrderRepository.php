<?php

namespace Modules\Order\Repositories\Dashboard;

use Modules\Order\Entities\OrderLog;
use Modules\Order\Entities\Order;
use DB;
use Auth;

class OrderRepository
{
    function __construct(Order $order,OrderLog $log)
    {
        $this->order = $order;
        $this->log   = $log;
    }

    public function getLogsByOrderId($id,$type)
    {
        return $this->log->where('order_id',$id)->where('type',$type)->get();
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->whereHas('orderStatus', function($query) {
                                    $query->successPayment();
                                })
                                ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as dates"))
                                ->groupBy('dates')
                                ->pluck('dates');

        $ordersIncome = $this->order->whereHas('orderStatus', function($query) {
                            $query->successPayment();
                        })
                        ->select(\DB::raw("sum(total) as profit"))
                        ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order
                    ->with('orderStatus')
                    ->select("order_status_id", \DB::raw("count(id) as count"))
                    ->groupBy('order_status_id')
                    ->get();


        foreach ($orders as $order) {

            $status = $order->orderStatus->translate(locale())->title;
            $order->type = $status;

        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"]  = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function completeOrders()
    {
        $orders = $this->order->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->count();

        return $orders;
    }

    public function getSuccessfullyOrders($request)
    {
        $orders = $this->order->where('date','!=',null)->whereHas('service', function($query) {
            $query->where('deleted_at',null);
        })->orderBy('id','DESC')->whereHas('orderStatus', function($query) {
            $query->successPayment();
        });

        if (isset($request['doctor_id']) && !empty($request['doctor_id'])) {
            $orders->where('doctor_id',$request['doctor_id']);
        }

        if (isset($request['clinic_id'])) {
            $orders->whereHas('doctor.clinic', function($query) use ($request){
                $query->where('clinic_id',$request['clinic_id']);
            });
        }

        return $orders->get();
    }

    public function totalProfit()
    {
        return $this->order->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->withDeleted()->find($id);

        return $order;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);

        $order->update([
          'unread'  => true,
        ]);
    }

    public function update($request,$id)
    {
        $order = $this->findById($id);

        $order->update([
            'order_status_id'  => $request['status_id'],
            'time_from'        => date('H:i:s', strtotime($request['time_from'])),
            'time_to'          => date('H:i:s', strtotime($request['time_to'])),
            'date'             => $request['date'],
        ]);

        return true;
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
        $query = $this->order->whereHas('service', function($query) {
            $query->where('deleted_at',null);
        })->with(['orderStatus','doctor','service','transactions','user'])->where(function($query) use($request){
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

        if (isset($request['req']['operator_id']))
             $query->where('operator_id' , $request['req']['operator_id']);

        if (isset($request['req']['status_id']))
            $query->where('order_status_id' , $request['req']['status_id']);


        if (isset($request['req']['user_id']))
            $query->where('user_id' , $request['req']['user_id']);

        if (isset($request['req']['service_id']))
            $query->where('service_id' , $request['req']['service_id']);

        if (isset($request['req']['clinics'])){
            $query->where(function($query) use ($request){
                $query->whereHas('doctor.clinic', function ($query) use ($request){
                    $query->where('clinic_id' , $request['req']['clinics']);
                })
                ->orWhereHas('operator.clinic', function ($query) use ($request){
                    $query->where('clinic_id' , $request['req']['clinics']);
                })
                ->orWhereHas('room.clinic', function ($query) use ($request){
                    $query->where('clinic_id' , $request['req']['clinics']);
                });
            });
        }

        return $query;
    }
}
