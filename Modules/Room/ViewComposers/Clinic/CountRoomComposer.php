<?php

namespace Modules\Room\ViewComposers\Clinic;

use Modules\Room\Repositories\Clinic\RoomRepository as Room;
use Illuminate\View\View;
use Cache;

class CountRoomComposer
{
    public function __construct(Room $user)
    {
        $this->countRooms  =  $user->countRooms();
    }

    public function compose(View $view)
    {
        $view->with('countRooms'    , $this->countRooms);
    }
}
