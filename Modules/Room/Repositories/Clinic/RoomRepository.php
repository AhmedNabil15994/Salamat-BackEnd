<?php

namespace Modules\Room\Repositories\Clinic;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Room\Entities\Room;
use ClinicFacade;
use Hash;
use DB;

class RoomRepository
{
    use SyncRelationModel;

    function __construct(Room $room)
    {
        $this->room      = $room;
    }

    /*
    * Get All Normal Rooms with Room Roles
    */
    public function getAllRooms($order = 'id', $sort = 'desc')
    {
        $rooms = $this->room->whereHas('clinic', function($query){
                        $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','room_access');
                  })->orderBy($order, $sort)->get();

        return $rooms;
    }

    public function countRooms($order = 'id', $sort = 'desc')
    {
        $rooms = $this->room->whereHas('clinic', function($query){
                        $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','room_access');
                  })->count();

        return $rooms;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $room = $this->room->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->withDeleted()->find($id);
        return $room;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $room = $this->room->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('email',$email)->first();
        return $room;
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
                $image = $request['image'] ? path_without_domain($request['image']) : '/uploads/users/user.png';

                $room = $this->room->create([
                    'name'          => $request['name'],
                    'status'        => $request->status ? 1 : 0,
                    'email'         => time().'@room.com',
                    'password'      => Hash::make('123123'),
                    'image'         => $image,
                ]);

                if($request['roles'] != null)
                    $this->syncRoles($room,$request);

                $this->clinic($room,$request);
                $this->shift($room,$request);
                $this->offDays($room,$request);
                $this->offTimes($room,$request);
                $this->offDates($room,$request);
                $this->customOff($room,$request);

          DB::commit();
          return $room;

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

        $room = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($room) : null;

        try {

            $image = $request['image'] ? path_without_domain($request['image']) : $room->image;

            $room->update([
                'name'          => $request['name'],
                'status'        => $request->status ? 1 : 0,
                'image'         => $image,
            ]);

            if($request['roles'] != null){
                DB::table('role_user')->where('user_id',$id)->delete();
                foreach ($request['roles'] as $key => $value) {
                    $room->attachRole($value);
                }
            }

            $this->clinic($room,$request);
            $this->shift($room,$request);
            $this->offDays($room,$request);
            $this->offTimes($room,$request);
            $this->offDates($room,$request);
            $this->customOff($room,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function syncRoles($room,$request)
    {
        foreach ($request['roles'] as $key => $value) {
            $room->attachRole($value);
        }

        return true;
    }

    public function shift($room,$request)
    {
        $room->shift()->updateOrCreate(
        [
            'shiftable_type' => 'Modules\Room\Entities\Room',
            'shiftable_id'   => $room['id']
        ],
        [
            'start_time'   => date('H:i:s', strtotime($request['open_time'])),
            'end_time'     => date('H:i:s', strtotime($request['close_time'])),
        ]);
    }

    public function clinic($room,$request)
    {
        $room->clinic()->updateOrCreate(
        [
            'room_id' => $room['id']
        ],
        [
            'clinic_id'   => ClinicFacade::id()
        ]);
    }

    public function offDays($room,$request)
    {
        $room->offDays()->delete();

        if (isset($request['off_days'])) {
            foreach ($request['off_days'] as $key => $day) {

                $room->offDays()->updateOrCreate([
                    'day'  => $day,
                ],[
                    'day'          => $day,
                    'start_time'   => date('H:i:s', strtotime($request['day_time_from'][$key])),
                    'end_time'     => date('H:i:s', strtotime($request['day_time_to'][$key])),
                ]);

            }
        }

    }

    public function offTimes($room,$request)
    {
        $oldValues = isset($request['old_off_times']['old']) ? $request['old_off_times']['old'] : [];

        $sync = $this->syncRelation($room,'offTimes',$oldValues);

        if ($sync['deleted']) {
           $room->offTimes()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $room->offTimes()->find($id)->update([
                    'time_from'   => date('H:i:s', strtotime($request['time_from_old'][$id])),
                    'time_to'     => date('H:i:s', strtotime($request['time_to_old'][$id])),
                ]);
            }
        }

        if ($request['time_to']) {
            foreach ($request['time_to'] as $key => $timeTo) {
                $room->offTimes()->create([
                  'time_to'     => date('H:i:s', strtotime($timeTo)),
                  'time_from'   => date('H:i:s', strtotime($request['time_from'][$key])),
                ]);
            }
        }
    }

    public function offDates($room,$request)
    {
        $oldValues = isset($request['old_off_dates']['old']) ? $request['old_off_dates']['old'] : [];

        $sync = $this->syncRelation($room,'offDates',$oldValues);

        if ($sync['deleted']) {
           $room->offDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $room->offDates()->find($id)->update([
                  'date_from'  => $request['date_from_old'][$id],
                  'date_to'    => $request['date_to_old'][$id],
                ]);
            }
        }

        if ($request['date_from']) {
            foreach ($request['date_from'] as $key => $dateFrom) {
                $room->offDates()->create([
                  'date_from'    => $dateFrom,
                  'date_to'      => $request['date_to'][$key],
                ]);
            }
        }
    }

    public function customOff($room,$request)
    {
        $oldValues = isset($request['old_custom_off']['old']) ? $request['old_custom_off']['old'] : [];

        $sync = $this->syncRelation($room,'offCustomDates',$oldValues);

        if ($sync['deleted']) {
           $room->offCustomDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $room->offCustomDates()->find($id)->update([
                  'date'       => $request['custom_old_date'][$id],
                  'time_from'   => date('H:i:s', strtotime($request['custom_time_from_old'][$id])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_to_from_old'][$id])),
                ]);
            }
        }

        if ($request['custom_date']) {
            foreach ($request['custom_date'] as $key => $customDate) {

                $room->offCustomDates()->create([
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
        $query = $this->room->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                 })->where('id','!=',auth()->id())->whereHas('roles.perms', function($query){
                        $query->where('name','room_access');
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
        // Search Rooms by Created Dates
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
