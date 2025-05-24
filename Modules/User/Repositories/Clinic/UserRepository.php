<?php

namespace Modules\User\Repositories\Clinic;

use Modules\User\Entities\User;
use ClinicFacade;
use Hash;
use DB;

class UserRepository
{

    function __construct(User $user)
    {
        $this->user      = $user;
    }

    /*
    * Get All Normal Users Without Roles
    */
    public function getClinicUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->where(function($query){
            $query->whereHas('orders.doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('orders.operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('orders.room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })->orderBy($order, $sort)->get();

        return $users;
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->user
        ->where(function($query){
            $query->whereHas('orders.doctor.clinic', function ($query) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('orders.operator.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            })
            ->orWhereHas('orders.room.clinic', function ( $query ) {
                $query->where('clinic_id',ClinicFacade::id());
            });
        })
        ->where('id','!=',auth()->id())->doesnthave('roles.perms')
        ->where(function($query) use($request){
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
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        return $query;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        return $this->user->withDeleted()->find($id);
    }

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request,$id)
    {
        DB::beginTransaction();

        $user = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($user) : null;

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : $user->image;

          if ($request['password'] == null)
              $password = $user['password'];
          else
              $password  = Hash::make($request['password']);

            $user->update([
                'name'          => $request['name'],
                // 'status'        => $request->status ? 1 : 0,
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if($request['roles'] != null)
            {
                DB::table('role_user')->where('user_id',$id)->delete();

                foreach ($request['roles'] as $key => $value) {
                    $user->attachRole($value);
                }
            }

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
}
