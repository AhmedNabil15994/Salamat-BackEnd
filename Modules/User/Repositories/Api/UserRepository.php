<?php

namespace Modules\User\Repositories\Api;

use Modules\User\Entities\User;
use Hash;
use DB;

class UserRepository
{

    function __construct(User $user)
    {
        $this->user  = $user;
    }


    public function changePassword($request)
    {
        $user = $this->findById(auth()->id());

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password  = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'password'      => $password,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request)
    {
        $user = auth()->user();

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password  = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'phone_code'    => '965',
                'password'      => $password,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function userProfile()
    {
        return auth()->user();
    }

    public function findById($id)
    {
        $user = $this->user->where('id',$id)->where('deleted_at',null)->first();

        return $user;
    }
}
