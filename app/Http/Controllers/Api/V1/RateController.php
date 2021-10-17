<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function store(Request $request)
    {
        $consumedEnergyInKwh = ($request->input('cdr.meterStop') - $request->input('cdr.meterStart')) / 1000;
        $energyValue = $request->input('rate.energy');
        $energy = round($consumedEnergyInKwh * $energyValue, 3);

        $startTime = Carbon::parse($request->input('cdr.timestampStart'));
        $stopTime = Carbon::parse($request->input('cdr.timestampStop'));

        $elpasedTimeInHours = $startTime->floatDiffInHours($stopTime);
        $time = round($elpasedTimeInHours * $request->input('rate.time'), 3);

        $transaction = $request->input('rate.transaction');

        $overall = round($energy + $time + $transaction, 2);

        return response()->json([
            "overall" => $overall,
            "components" => [
                "energy" => $energy,
                "time" => $time,
                "transaction" => $transaction
            ]
        ]);
    }

}
