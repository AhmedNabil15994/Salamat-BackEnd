<?php

namespace Modules\Clinic\Facades;

use Modules\Clinic\Entities\Clinic;

class ClinicFacade
{
    static protected function clinic()
    {
        if (auth()->user()) {

            if (auth()->user()->can('doctor_access')) {

                return Clinic::whereHas('doctors', function($query) {
                    $query->where('doctor_id', auth()->user()->id);
                })->first();
            }

            if (auth()->user()->can('operator_access')) {
                return Clinic::whereHas('operators', function($query) {
                    $query->where('operator_id', auth()->user()->id);
                })->first();
            }

            return Clinic::whereHas('staff', function($query) {
                $query->where('staff_id', auth()->user()->id);
            })->first();
        }

        return false;
    }

    static public function data()
    {
        $clinic = self::clinic();

        if ($clinic)
            return $clinic;

        return false;
    }

    static public function id()
    {
        $clinic = self::clinic();

        if ($clinic)
            return $clinic->id;

        return false;
    }

    static public function logo()
    {
        $clinic = self::clinic();

        if ($clinic)
            return url($clinic->image);

        return false;
    }

    static public function title()
    {
        $clinic = self::clinic();

        if ($clinic)
            return $clinic->translate(locale())->title;

        return false;
    }

    static public function blogs_limit()
    {
        $clinic = self::clinic();

        if ($clinic)
            return $clinic->blogs_limit;

        return false;
    }
}
