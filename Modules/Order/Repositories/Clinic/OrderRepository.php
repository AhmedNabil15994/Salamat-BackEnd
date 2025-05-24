<?php

namespace Modules\Order\Repositories\Clinic;

use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\Order;
use ClinicFacade;
use Auth;
use DB;

class OrderRepository
{
    function __construct(Order $order,OrderStatus $status)
    {
        $this->order   = $order;
        $this->status   = $status;
    }

    public function getSuccessfullyOrders($request)
    {
        $orders = $this->order->where('date','!=',null)->orderBy('id','DESC');

        $orders->whereHas('service', function($query) {
            $query->where('deleted_at',null);
        })->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        });

        $orders->whereHas('orderStatus', function($query) {
            $query->successPayment();
        });

        if (auth()->check() && auth()->user()->can('doctor_access')) {
            $orders->where('doctor_id',auth()->id());
        }

        if (auth()->check() && auth()->user()->can('operator_access')) {
            $orders->where('operator_id',auth()->id());
        }

        if (isset($request['doctor_id']) && !empty($request['doctor_id'])) {
            $orders->where('doctor_id',$request['doctor_id']);
        }

        if (isset($request['clinic_id']) && !empty($request['clinic_id'])) {
            $orders->whereHas('doctor.clinic', function($query) use ($request){
                $query->where('clinic_id',$request['clinic_id']);
            });
        }

        if (isset($request['operator_id']) && !empty($request['operator_id']))
             $orders->where('operator_id' , $request['operator_id']);

        if (isset($request['user_id']) && !empty($request['user_id']))
            $orders->where('user_id' , $request['user_id']);

        if (isset($request['service_id']) && !empty($request['service_id']))
            $orders->where('service_id' , $request['service_id']);

        return $orders->get();
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $paid = $request->is_paid ? true : false;

            $status = $this->statusOfOrder($paid);

            $order = $this->order->create([
                'user_id'           => $request->user_id,
                'doctor_id'         => $request->ignore_doctor ? null : $request->doctor_id,
                'operator_id'       => $request->operator_id,
                'room_id'           => $request->room_id,
                'service_id'        => $request->service_id,
                'subtotal'          => $request->service_price,
                'discount'          => $request->service_price - $request->total,
                'total'             => $request->total,
                'date'              => $request['date'] ? $request['date'] : null,
                'time_from'         => $request['time_from'] ? date('H:i:s', strtotime($request['time_from'])) : null,
                'time_to'           => $request['time_to'] ? date('H:i:s', strtotime($request['time_to'])) : null,
                'is_paid'           => $paid ? true : false,
                'is_pending'        => $paid ? false : true,
                'is_holding'        => false,
                'order_status_id'   => $status->id,
            ]);

            $order->transactions()->create([
                'method' => 'Clinic Order',
                'result' => 'Clinic Order',
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){

            DB::rollback();
            throw $e;

        }
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as dates"))
        ->groupBy('dates')
        ->pluck('dates');

        $ordersIncome = $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->select(\DB::raw("sum(total) as profit"))
        ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
        ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order->whereHas('doctor.clinic', function($query) {
                        $query->where('clinic_id',ClinicFacade::id());
                  })->with('orderStatus')
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
        $orders = $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->whereHas('orderStatus', function($query) {
            $query->successPayment();
        })->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->orderBy($order, $sort)->get();

        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->withDeleted()->find($id);

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
        $query = $this->order->with(['orderStatus','doctor','service','transactions','user']);

        if (auth()->check() && auth()->user()->can('doctor_access')) {
            $query->where('doctor_id',auth()->id());
        }

        if (auth()->check() && auth()->user()->can('operator_access')) {
            $query->where('operator_id',auth()->id());
        }

        $query->whereHas('service', function($query) {
            $query->where('deleted_at',null);
        });

        $query->where(function($query){
            $query->whereHas('doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        });

        $query->where(function($query) use($request){
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

        return $query;
    }

    public function statusOfOrder($type)
    {
        if ($type)
            $status = $this->status->successPayment()->first();

        if (!$type)
            $status = $this->status->failedPayment()->first();

        return $status;
    }

}
