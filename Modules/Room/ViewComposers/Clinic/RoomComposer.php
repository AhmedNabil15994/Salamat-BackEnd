<?php

namespace Modules\Room\ViewComposers\Clinic;

use Modules\Room\Repositories\Clinic\RoomRepository as Room;
use Illuminate\View\View;
use Cache;

class RoomComposer
{
    public $rooms = [];

    public function __construct(Room $room)
    {
        $this->rooms =  $room->getAllRooms();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('rooms' , $this->rooms);
    }
}
