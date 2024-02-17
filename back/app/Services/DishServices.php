<?php

namespace App\Services;

use App\Models\Dish;
use Illuminate\Support\Carbon;

class DishServices
{
    public function checkAvailable(int $id): bool
    {
        $dish = Dish::query()->find($id);

        if (!$dish->is_available) return false;

        $date = Carbon::now(7);
        $day = $date->dayOfWeekIso;
        $time = $date->toTimeString();

        if ($day == 6 || $day == 7) {
            $start = $dish->category()->weekend_available_start;
            $end = $dish->category()->weekend_available_end;
        } else {
            $start = $dish->category()->weekday_available_start;
            $end = $dish->category()->weekday_available_end;
        }

        if (!$this->isSetTimeLimit($start, $end)) return false;

        return $this->isTimeInRange($time, $start, $end);
    }

    private function isTimeInRange($time, $startTime, $endTime)
    {
        $timeObj = Carbon::createFromFormat('H:i:s', $time);
        $startObj = Carbon::createFromFormat('H:i:s', $startTime);
        $endObj = Carbon::createFromFormat('H:i:s', $endTime);

        if ($startObj->greaterThan($endObj)) {
            $midnight = Carbon::createFromFormat('H:i:s', '23:59:59');
            return ($timeObj->between($startObj, $midnight))
                || ($timeObj->between(Carbon::createFromFormat('H:i:s', '00:00:00'), $endObj));
        } else {
            return $timeObj->between($startObj, $endObj);
        }
    }

    private function isSetTimeLimit($start, $end): bool
    {
        if (is_null($start) || is_null($end)) {
            return false;
        }
        return true;
    }
}