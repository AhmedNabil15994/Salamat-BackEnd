<?php

namespace Modules\Availability\Traits;

trait AvailabilityTrait
{
    public function availabilityChecker($service,$request)
    {
        if ($service->ignore_doctor == true) {
            $serviceTeam['doctor']    = $this->ignoreDoctor($service->doctor->doctor,$request);
        }else{
            $serviceTeam['doctor']    = $this->checkDoctorAvailability($service->doctor->doctor,$request);
        }

        $serviceTeam['room']      = (count($service->rooms) > 0) ?
        $this->checkRoomAvailability($service->rooms,$request) : false;

        $serviceTeam['operator']  = (count($service->operators) > 0) ?
        $this->checkOperaorAvailability($service->operators,$request) : false;

        return $serviceTeam;
    }

    public function checkDoctorAvailability($doctor,$request)
    {
        $error     = null;

        $notInShift     =  $this->shift($doctor->shift,$request);
        $offDay         =  $this->offDay($doctor->offDays,$request);
        $dailyBreak     =  $this->dailyBreak($doctor->offTimes,$request);
        $offDates       =  $this->offDates($doctor->offDates,$request);
        $offCustomDates =  $this->offCustomDates($doctor->offCustomDates,$request);
        $orders         =  $this->upcomingOrders($doctor->upcomingOrders,$request);

        if (!is_null($notInShift) ||
            !is_null($offDay) ||
            ($dailyBreak != 0) ||
            ($offDates != 0) ||
            ($offCustomDates != 0) ||
            ($orders != 0)) {

            $error = 'not available';

        }

        return ['error' => $error , 'data' => $doctor];
    }

    public function ignoreDoctor($doctor,$request)
    {
        return ['error' => null , 'data' => $doctor];
    }

    public function checkRoomAvailability($rooms,$request)
    {
        $error = null;

        if (count($rooms) > 0) {

            $room = $rooms->random();

            $notInShift     =  $this->shift($room->shift,$request);
            $offDay         =  $this->offDay($room->offDays,$request);
            $dailyBreak     =  $this->dailyBreak($room->offTimes,$request);
            $offDates       =  $this->offDates($room->offDates,$request);
            $offCustomDates =  $this->offCustomDates($room->offCustomDates,$request);
            $orders         =  $this->upcomingOrders($room->upcomingOrders,$request);

            if (!is_null($notInShift) ||
                !is_null($offDay) ||
                ($dailyBreak != 0) ||
                ($offDates != 0) ||
                ($offCustomDates != 0) ||
                ($orders != 0)) {

                $error = 'not available';

                if (!empty($error)) {

                    $rooms = $this->rejectFromCollection($rooms,$room);
                    return self::checkRoomAvailability($rooms,$request);
                }
            }

        }else{
            return ['error' => 'not available', 'room' => null];
        }

        return [ 'error' => $error , 'data' => $room ];
    }

    public function checkOperaorAvailability($operators,$request)
    {
        $error = null;

        if (count($operators) > 0) {

            $operator = $operators->random();

            $notInShift =  $this->shift($operator->shift,$request);
            $offDay     =  $this->offDay($operator->offDays,$request);
            $dailyBreak =  $this->dailyBreak($operator->offTimes,$request);
            $offDates   =  $this->offDates($operator->offDates,$request);
            $offCustomDates =  $this->offCustomDates($operator->offCustomDates,$request);
            $orders         =  $this->upcomingOrders($operator->upcomingOrders,$request);

            if (!is_null($notInShift) ||
                !is_null($offDay) ||
                ($dailyBreak != 0) ||
                ($offDates != 0) ||
                ($offCustomDates != 0) ||
                ($orders != 0)) {

                $error = 'not available';

                if (!empty($error)) {
                    $operators = $this->rejectFromCollection($operators,$operator);
                    return self::checkOperaorAvailability($operators,$request);
                }
            }

        }else{
            return ['error' => 'not available', 'operator' => null];
        }

        return [ 'error' => $error , 'data' => $operator ];
    }

    public function shift($shift,$request)
    {
        $error = null;

        $exp1 = ($request['time_from'] >= $shift['start_time'] && $request['time_from'] < $shift['end_time']);
        $exp2 = ($request['time_to'] > $shift['start_time'] && $request['time_to'] <= $shift['end_time']);

        return ($exp1 && $exp2) ? null :'out of shift';
    }

    public function offDay($offDays,$request)
    {
        // Key the days by day name 'day'.. we gonna need this down below.
        $offDaysByKey = $offDays->keyBy('day');

        $dayOfOrder =  strtolower(date("l", strtotime($request['date'])));
        $offDays    = $offDays->pluck('day')->toArray();

        $result = in_array($dayOfOrder,$offDays) ? 'off day' : null;

        // Return if there's no off days..
        if (! $result) {
            return $result;
        }

        // Day has off time, check the time!

        $day = $offDaysByKey[$dayOfOrder];

        $start = strtotime($day['start_time']);
        $end   = strtotime($day['end_time']);

        $req_start = strtotime($request->time_from);
        $req_to    = strtotime($request->time_to);

        return $req_start >= $end || $req_to <= $start ? null : 'off day';
    }

    public function dailyBreak($dailyBreaks,$request)
    {
        $errors = 0;

        if (count($dailyBreaks) > 0) {

            foreach ($dailyBreaks as $break) {

                $exp1 = ($request['time_from'] >= $break['time_from'] && $request['time_from'] < $break['time_to']);
                $exp2 = ($request['time_to'] > $break['time_from'] && $request['time_to'] <= $break['time_to']);

                if($exp1 || $exp2)
                    ++$errors;
            }

        }

        return $errors;
    }

    public function offDates($offDates,$request)
    {
        $errors = 0;

        if (count($offDates) > 0) {

            foreach ($offDates as $offDate) {

                $exp1 = ($request['date'] >= $offDate['date_from'] && $request['date'] < $offDate['date_to']);

                if($exp1)
                    ++$errors;
            }

        }

        return $errors;
    }

    public function offCustomDates($offCustomDates,$request)
    {
        $errors = 0;

        if (count($offCustomDates) > 0) {

            foreach ($offCustomDates as $off) {

                $exp1 = ($request['date'] == $off['date']);
                $exp2 = ($request['time_from'] >= $off['time_from'] && $request['time_from'] < $off['time_to']);
                $exp3 = ($request['time_to'] > $off['time_from'] && $request['time_to'] <= $off['time_to']);

                if($exp1 && ($exp2 || $exp3))
                    ++$errors;
            }

        }

        return $errors;
    }

    public function upcomingOrders($orders,$request)
    {
        $errors = 0;

        if (count($orders) > 0) {

            foreach ($orders as $order) {

                $exp1 = ($request['date'] == $order['date']);

                $exp2 = ($request['time_from'] >= $order['time_from'] && $request['time_from'] < $order['time_to']);
                $exp3 = ($request['time_to'] > $order['time_from'] && $request['time_to'] <= $order['time_to']);
                $exp4 = ($order['time_from'] >= $request['time_from'] && $order['time_from'] < $request['time_to']);
                $exp5 = ($order['time_to'] > $request['time_from'] && $order['time_to'] <= $request['time_to']);

                if($exp1 && ($exp2 || $exp3 || $exp4 || $exp5))
                    ++$errors;
            }

        }

        return $errors;
    }

    public function rejectFromCollection($collection,$object)
    {
        $newCollection = $collection->reject(function ($item) use($object){
            return $item['id'] == $object['id'];
        });

        return $newCollection->values();
    }
}
