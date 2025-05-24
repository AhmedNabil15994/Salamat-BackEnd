<?php

namespace Modules\Staff\Repositories\Clinic;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Staff\Entities\Staff;
use ClinicFacade;
use Hash;
use DB;

class StaffRepository
{
    use SyncRelationModel;

    function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    /*
    * Get All Normal Staffs with Staff Roles
    */
    public function getAllStaffs($order = 'id', $sort = 'desc')
    {
        $staffs = $this->staff->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','clinic_access');
                      })->orderBy($order, $sort)->get();
        return $staffs;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $staff = $this->staff->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->withDeleted()->find($id);
        return $staff;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $staff = $this->staff->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('email',$email)->first();
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
            'clinic_id'   => ClinicFacade::id()
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
        $query = $this->staff->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('id','!=',auth()->id())->whereHas('roles.perms', function($query){

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

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();


        return $query;
    }

}
