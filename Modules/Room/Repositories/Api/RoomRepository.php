<?php

namespace Modules\Room\Repositories\Api;

use Modules\Room\Entities\Room;
use Hash;
use DB;

class RoomRepository
{

    function __construct(Room $room)
    {
        $this->room      = $room;
    }

    public function getAllRoomsPaginate($request)
    {
        $rooms = $this->room->whereHas('roles.perms', function($query){
                       $query->where('name','room_access');
                    })->orderBy('id', 'desc');

        if ($request['clinic_id']) {
            $rooms->whereHas('pivotClinic', function($query) use($request){
                $query->where('clinic_id',$request['clinic_id']);
             });
        }

        return $rooms->paginate(24);
    }

    public function findById($id)
    {
        $room = $this->room->where('id',$id)->whereHas('roles.perms', function($query){
                     $query->where('name','room_access');
                  })->first();

        return $room;
    }
}
