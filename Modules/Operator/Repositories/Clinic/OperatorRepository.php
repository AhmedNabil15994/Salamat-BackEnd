<?php

namespace Modules\Operator\Repositories\Clinic;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Operator\Entities\Operator;
use ClinicFacade;
use Hash;
use DB;

class OperatorRepository
{
    use SyncRelationModel;

    function __construct(Operator $operator)
    {
        $this->operator = $operator;
    }

    /*
    * Get All Normal Operators with Operator Roles
    */
    public function getAllOperators($order = 'id', $sort = 'desc')
    {
        $operators = $this->operator->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','operator_access');
                      })->orderBy($order, $sort)->get();
        return $operators;
    }

    public function countOperators($order = 'id', $sort = 'desc')
    {
        $operators = $this->operator->whereHas('clinic', function($query){
                        $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','operator_access');
                  })->count();

        return $operators;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $operator = $this->operator->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->withDeleted()->find($id);
        return $operator;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $operator = $this->operator->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('email',$email)->first();
        return $operator;
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
                $image = $request['image'] ? path_without_domain($request['image']) : '/uploads/users/user.png';

                $operator = $this->operator->create([
                    'name'          => $request['name'],
                    'status'        => $request->status ? 1 : 0,
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'password'      => Hash::make($request['password']),
                    'image'         => $image,
                ]);

                if($request['roles'] != null)
                    $this->syncRoles($operator,$request);

                $this->clinic($operator,$request);
                $this->shift($operator,$request);
                $this->offDays($operator,$request);
                $this->offTimes($operator,$request);
                $this->offDates($operator,$request);
                $this->customOff($operator,$request);

          DB::commit();
          return $operator;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request,$id)
    {
        DB::beginTransaction();

        $operator = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($operator) : null;

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : $operator->image;

          if ($request['password'] == null)
              $password = $operator['password'];
          else
              $password  = Hash::make($request['password']);

            $operator->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if($request['roles'] != null){
                DB::table('role_user')->where('user_id',$id)->delete();
                foreach ($request['roles'] as $key => $value) {
                    $operator->attachRole($value);
                }
            }


            $this->clinic($operator,$request);
            $this->shift($operator,$request);
            $this->offDays($operator,$request);
            $this->offTimes($operator,$request);
            $this->offDates($operator,$request);
            $this->customOff($operator,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function syncRoles($operator,$request)
    {
        foreach ($request['roles'] as $key => $value) {
            $operator->attachRole($value);
        }

        return true;
    }

    public function shift($operator,$request)
    {
        $operator->shift()->updateOrCreate(
        [
            'shiftable_type' => 'Modules\Operator\Entities\Operator',
            'shiftable_id'   => $operator['id']
        ],
        [
            'start_time'   => date('H:i:s', strtotime($request['open_time'])),
            'end_time'     => date('H:i:s', strtotime($request['close_time'])),
        ]);
    }

    public function clinic($operator,$request)
    {
        $operator->clinic()->updateOrCreate(
        [
            'operator_id' => $operator['id']
        ],
        [
            'clinic_id'   => ClinicFacade::id()
        ]);
    }

    public function offDays($operator,$request)
    {
        $operator->offDays()->delete();

        if (isset($request['off_days'])) {
            foreach ($request['off_days'] as $key => $day) {

                $operator->offDays()->updateOrCreate([
                    'day'  => $day,
                ],[
                    'day'          => $day,
                    'start_time'   => date('H:i:s', strtotime($request['day_time_from'][$key])),
                    'end_time'     => date('H:i:s', strtotime($request['day_time_to'][$key])),
                ]);

            }
        }

    }

    public function offTimes($operator,$request)
    {
        $oldValues = isset($request['old_off_times']['old']) ? $request['old_off_times']['old'] : [];

        $sync = $this->syncRelation($operator,'offTimes',$oldValues);

        if ($sync['deleted']) {
           $operator->offTimes()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $operator->offTimes()->find($id)->update([
                    'time_from'   => date('H:i:s', strtotime($request['time_from_old'][$id])),
                    'time_to'     => date('H:i:s', strtotime($request['time_to_old'][$id])),
                ]);
            }
        }

        if ($request['time_to']) {
            foreach ($request['time_to'] as $key => $timeTo) {
                $operator->offTimes()->create([
                  'time_to'     => date('H:i:s', strtotime($timeTo)),
                  'time_from'   => date('H:i:s', strtotime($request['time_from'][$key])),
                ]);
            }
        }
    }

    public function offDates($operator,$request)
    {
        $oldValues = isset($request['old_off_dates']['old']) ? $request['old_off_dates']['old'] : [];

        $sync = $this->syncRelation($operator,'offDates',$oldValues);

        if ($sync['deleted']) {
           $operator->offDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $operator->offDates()->find($id)->update([
                  'date_from'  => $request['date_from_old'][$id],
                  'date_to'    => $request['date_to_old'][$id],
                ]);
            }
        }

        if ($request['date_from']) {
            foreach ($request['date_from'] as $key => $dateFrom) {
                $operator->offDates()->create([
                  'date_from'    => $dateFrom,
                  'date_to'      => $request['date_to'][$key],
                ]);
            }
        }
    }

    public function customOff($operator,$request)
    {
        $oldValues = isset($request['old_custom_off']['old']) ? $request['old_custom_off']['old'] : [];

        $sync = $this->syncRelation($operator,'offCustomDates',$oldValues);

        if ($sync['deleted']) {
           $operator->offCustomDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $operator->offCustomDates()->find($id)->update([
                  'date'       => $request['custom_old_date'][$id],
                  'time_from'   => date('H:i:s', strtotime($request['custom_time_from_old'][$id])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_to_from_old'][$id])),
                ]);
            }
        }

        if ($request['custom_date']) {
            foreach ($request['custom_date'] as $key => $customDate) {

                $operator->offCustomDates()->create([
                  'date'      => $customDate,
                  'time_from' => date('H:i:s', strtotime($request['custom_time_from'][$key])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_time_to'][$key])),
                ]);

            }
        }
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

    /*
    * Find all Objects By IDs & Delete it from DB
    */
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

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->operator->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('id','!=',auth()->id())->whereHas('roles.perms', function($query){

                        $query->where('name','operator_access');

                })->where(function($query) use($request){

                        $query->where('id'                , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('name'            , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('email'           , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('mobile'          , 'like' , '%'. $request->input('search.value') .'%');

                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query,$request)
    {
        // Search Operators by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        if (isset($request['req']['roles'])){

            $query->whereHas('roles', function ($query) use ($request){
                $query->where('id',$request['req']['roles']);
            });

        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();


        return $query;
    }

}
