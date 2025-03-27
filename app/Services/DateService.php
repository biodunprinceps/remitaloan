<?php
namespace App\Services;

use Carbon\Carbon;

class DateService
{

    public static function getNextWorkingDate($date)
    {
        $carbonDate = Carbon::createFromFormat('Y-m-d', $date);

        while (self::isWeekend($carbonDate)) {
            // $carbonDate->addDay();
            $carbonDate->subDay();

            //
        }

        while (self::isPublicHoliday($carbonDate)) {
            $carbonDate->subDay();
            // $carbonDate->addDay();
        }

        return $carbonDate->format('Y-m-d');
    }

    protected static function isWeekend($date)
    {
        return $date->isWeekend();
    }

    protected static function isPublicHoliday($date)
    {
        if ($date->month === 12 && $date->day === 25) {
            return true;
        } elseif ($date->month === 12 && $date->day === 26) {
            return true;
        } elseif ($date->month === 1 && $date->day === 1) {
            return true;
        } elseif ($date->month === 1 && $date->day === 2) {
            return true;
        } elseif ($date->month === 5 && $date->day === 1) {
            return true;
        } elseif ($date->month === 5 && $date->day === 29) {
            return true;
        } elseif ($date->month === 6 && $date->day === 12) {
            return true;
        } elseif ($date->month === 10 && $date->day === 1) {
            return true;
        } elseif ($date->month === 10 && $date->day === 2) {
            return true;
        }

        return false;
    }
}
