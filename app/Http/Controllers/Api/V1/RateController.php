<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RatingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RateController extends Controller
{
    private $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    public function store(Request $request)
    {
        $this->validateStore($request);

        $energy = $this->ratingService->calculateEnergyRate(
            $request->input('cdr.meterStart'),
            $request->input('cdr.meterStop'),
            $request->input('rate.energy')
        );

        $time = $this->ratingService->calculateElpasedTimeRate(
            Carbon::parse($request->input('cdr.timestampStart')),
            Carbon::parse($request->input('cdr.timestampStop')),
            $request->input('rate.time')
        );

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

    private function validateStore(Request $request)
    {
        $this->validate($request, [
            'rate.energy' => ['required', 'numeric'],
            'rate.time' => ['required', 'numeric'],
            'rate.transaction' => ['required', 'numeric'],
            'cdr.meterStart' => ['required', 'integer'],
            'cdr.meterStop' => ['required', 'integer'],
            'cdr.timestampStart' => ['required', 'date'],
            'cdr.timestampStop' => ['required', 'date'],
        ]);

    }

}
