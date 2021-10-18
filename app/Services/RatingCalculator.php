<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;

class RatingCalculator
{
    public function calculateOverallWithDetails(array $cdr, array $rate)
    {
        $energy = $this->calculateEnergyRate($cdr['meterStart'], $cdr['meterStop'], $rate['energy']);

        $time = $this->calculateElpasedTimeRate(
            Carbon::parse($cdr['timestampStart']), Carbon::parse($cdr['timestampStop']), $rate['time']
        );

        $transaction = $rate['transaction'];

        $overall = $this->calculateOverall($energy, $time, $transaction);

        return compact('overall', 'time', 'energy', 'transaction');

    }

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

    public function calculateOverall(float $energy, float $time, int $transaction)
    {
        return round($energy + $time + $transaction, 2);
    }
}


