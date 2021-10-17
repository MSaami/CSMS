<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;

class RatingService
{

    public function calculateEnergyRate(int $meterStart, int $meterStop, float $energyValue)
    {
        $consumedEnergyInKwh = ($meterStop - $meterStart) / 1000;

        return round($consumedEnergyInKwh * $energyValue, 3);
    }

    public function calculateElpasedTimeRate(Carbon $startTime, Carbon $stopTime, float $timeValue)
    {
        $elpasedTimeInHours = $startTime->floatDiffInHours($stopTime);
        return round($elpasedTimeInHours * $timeValue, 3);
    }
}


