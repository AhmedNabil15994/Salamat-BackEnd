<?php

namespace Modules\Availability\Traits;

trait ShiftTrait
{
    public function availabiltyTimes($person,$serviceTakeTime)
    {
        $availabilty = [];

        $times           = $this->groupTimes($person,$serviceTakeTime);
        $timesWithBreaks = $this->groupTimesWithBreaks($times,$person->offTimes);
        $dates           = $this->groupDates($person);
        $datesWithBreaks = $this->groupDatesWithBreaks($dates,$person->offDates);
        $schedule        = $this->customOfDates($datesWithBreaks,$timesWithBreaks,$person->offCustomDates);
        $final           = $this->offDays($schedule,$person->offDays);

        foreach ($final as $date => $times) {
            $data['day']   = $date;
            $data['times'] = $times;
            $dateTimes[]  = $data;
        }

        return $dateTimes;

    }

    public function groupTimes($person,$serviceTakeTime)
    {
        $times = [];
        $serviceTakeTime =  strtotime($serviceTakeTime) - strtotime('today');

        $open_time   = strtotime($person->shift->start_time);
        $close_time  = strtotime($person->shift->end_time);

        $x = $open_time;

        for($i = $open_time; $x < $close_time; $i) {

            $output['from'] = date("H:i:00",$i);
            $to             = $i+=$serviceTakeTime;
            $output['to']   = date("H:i:00",$to);

            $x = $to+=$serviceTakeTime;

            $times[] = $output;
        }

        return $times;
    }

    public function groupTimesWithBreaks($groupOfTimes,$breaks)
    {
        if (count($breaks) > 0) {

            $exp = collect($breaks);

            return collect($groupOfTimes)->filter(function ($time, $key) use ($exp) {
                return $exp->every(function ($off, $key) use ($time) {
                    return ! ($time['from'] >= $off['time_from'] && $time['to'] <= $off['time_to']);
                });
            })->values();

        }

        return $groupOfTimes;
    }

    public function groupDates($person)
    {
        $date     = date("Y-m-d");
        $end_date = date ("Y-m-d", strtotime("+2 months", strtotime(date("Y-m-d"))));

        $days = [];

        while (strtotime($date) <= strtotime($end_date)) {

            $days[] = $date;

            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        return $days;
    }

    public function groupDatesWithBreaks($groupOfDates,$breaks)
    {
        if (count($breaks) > 0) {

            $exp = collect($breaks);

            return collect($groupOfDates)->filter(function ($date, $key) use ($exp) {
                return $exp->every(function ($off, $key) use ($date) {
                    return ! ($date >= $off['date_from'] && $date <= $off['date_to']);
                });
            })->values();

        }

        return $groupOfDates;
    }

    public function customOfDates($datesWithBreaks,$timesWithBreaks,$exceptions)
    {
        foreach ($datesWithBreaks as $key => $value) {
            $times[$value]   = $timesWithBreaks;
        }

        $exceptions = collect($exceptions);

        $results = [];

        collect($times)->each(function ($times, $dateKey) use (&$results, $exceptions) {
            $results[$dateKey] = collect($times)->filter(function ($time, $key) use ($exceptions,$dateKey) {
                return $exceptions->where('date',$dateKey)->every(function ($item, $key) use ($time){
                    return !($time['from'] >= $item['time_from'] && $time['to'] <= $item['time_to']);
                });
            })->values();
        });

        return $results;
    }

    public function offDays($schedule,$exceptions)
    {
        $exceptions = $exceptions->keyBy('day');

        $results = [];

        collect($schedule)->each(function ($times, $dateKey) use (&$results, $exceptions) {
            $off = $exceptions->get(strtolower(date('l', strtotime($dateKey))));
            $results[$dateKey] = collect($times)->filter(function ($time, $key) use ($off) {
                return is_null($off) || !($time['from'] >= $off['start_time'] && $time['to'] <= $off['end_time']);
            })->values();

        });

        return $results;
    }
}
