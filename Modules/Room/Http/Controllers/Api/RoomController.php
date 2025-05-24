<?php

namespace Modules\Room\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Room\Transformers\Api\RoomResource;
use Modules\Room\Repositories\Api\RoomRepository as Room;
use Modules\Apps\Http\Controllers\Api\ApiController;

class RoomController extends ApiController
{

    function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function list(Request $request)
    {
        $rooms =  $this->room->getAllRoomsPaginate($request);

        return RoomResource::collection($rooms);
    }

    public function room($id)
    {
        $room = $this->room->findById($id);

        if(!$room)
          return $this->response([]);

        return $this->response(new RoomResource($room));
    }
}
