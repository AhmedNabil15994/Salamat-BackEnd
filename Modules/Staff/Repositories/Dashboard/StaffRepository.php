<?php

namespace Modules\Staff\Repositories\Dashboard;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Staff\Entities\Staff;
use Hash;
use DB;

class StaffRepository
{
    use SyncRelationModel;

    function __construct(Staff $staff)
    {
        $this->staff      = $staff;
    }

    /*
    * Get All Normal Staffs with Staff Roles
    */
    public function getAllStaffs($order = 'id', $sort = 'desc')
    {
        $staffs = $this->staff->whereHas('roles.perms', function($query){
                        $query->where('name','clinic_access');
                      })->orderBy($order, $sort)->get();
        return $staffs;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $staff = $this->staff->withDeleted()->find($id);
        return $staff;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $staff = $this->staff->where('email',$email)->first();
        return $staff;
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
                $image = $request['image'] ? path_without_domain($request['image']) : '/uploads/users/user.png';

                $staff = $this->staff->create([
                    'name'          => $request['name'],
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'password'      => Hash::make($request['password']),
                    'image'         => $image,
                ]);

                if($request['roles'] != null)
                    $this->syncRoles($staff,$request);

               $this->clinic($staff,$request);

          DB::commit();
          return $staff;

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

        $staff = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($staff) : null;

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : $staff->image;

          if ($request['password'] == null)
              $password = $staff['password'];
          else
              $password  = Hash::make($request['password']);

            $staff->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if($request['roles'] != null){
                DB::table('role_user')->where('user_id',$id)->delete();
                foreach ($request['roles'] as $key => $value) {
                    $staff->attachRole($value);
                }
            }

            $this->clinic($staff,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function syncRoles($staff,$request)
    {
        foreach ($request['roles'] as $key => $value) {
            $staff->attachRole($value);
        }

        return true;
    }

    public function clinic($staff,$request)
    {
        $staff->clinic()->updateOrCreate(
        [
            'staff_id' => $staff['id']
        ],
        [
            'clinic_id'   => $request['clinic_id']
        ]);
    }

    public function offDays($staff,$request)
    {
        foreach ($request['off_days'] as $day) {

            $staff->offDays()->updateOrCreate([
                'day'  => $day,
            ],[
                'day'   => $day,
            ]);

        }

    }

    public function offTimes($staff,$request)
    {
        $oldValues = isset($request['old_off_times']['old']) ? $request['old_off_times']['old'] : [];

        $sync = $this->syncRelation($staff,'offTimes',$oldValues);

        if ($sync['deleted']) {
           $staff->offTimes()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $staff->offTimes()->find($id)->update([
                  'time_from'  => $request['time_from_old'][$id],
                  'time_to'    => $request['time_to_old'][$id],
                ]);
            }
        }

        if ($request['time_to']) {
            foreach ($request['time_to'] as $key => $timeTo) {
                $staff->offTimes()->create([
                  'time_to'    => $timeTo,
                  'time_from'  => $request['time_from'][$key],
                ]);
            }
        }
    }

    public function offDates($staff,$request)
    {
        $oldValues = isset($request['old_off_dates']['old']) ? $request['old_off_dates']['old'] : [];

        $sync = $this->syncRelation($staff,'offDates',$oldValues);

        if ($sync['deleted']) {
           $staff->offDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $staff->offDates()->find($id)->update([
                  'date_from'  => $request['date_from_old'][$id],
                  'date_to'    => $request['date_to_old'][$id],
                ]);
            }
        }

        if ($request['date_from']) {
            foreach ($request['date_from'] as $key => $dateFrom) {
                $staff->offDates()->create([
                  'date_from'    => $dateFrom,
                  'date_to'      => $request['date_to'][$key],
                ]);
            }
        }
    }

    public function customOff($staff,$request)
    {
        $oldValues = isset($request['old_custom_off']['old']) ? $request['old_custom_off']['old'] : [];

        $sync = $this->syncRelation($staff,'offCustomDates',$oldValues);

        if ($sync['deleted']) {
           $staff->offCustomDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $staff->offCustomDates()->find($id)->update([
                  'date'       => $request['custom_old_date'][$id],
                  'time_from'  => $request['custom_time_from_old'][$id],
                  'time_to'    => $request['custom_to_from_old'][$id],
                ]);
            }
        }

        if ($request['custom_date']) {
            foreach ($request['custom_date'] as $key => $customDate) {

                $staff->offCustomDates()->create([
                  'date'      => $customDate,
                  'time_from' => $request['custom_time_from'][$key],
                  'time_to'   => $request['custom_time_to'][$key],
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
        $query = $this->staff->where('id','!=',auth()->id())->whereHas('roles.perms', function($query){

                        $query->where('name','clinic_access');

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
        // Search Staffs by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        if (isset($request['req']['roles'])){

            $query->whereHas('roles', function ($query) use ($request){
                $query->where('id',$request['req']['roles']);
            });

        }

        if (isset($request['req']['clinics'])){

            $query->whereHas('clinic', function ($query) use ($request){
                $query->where('clinic_id',$request['req']['clinics']);
            });

        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();


        return $query;
    }

}
