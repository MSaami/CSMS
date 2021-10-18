<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RatingCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RateController extends Controller
{
    private $ratingCalculator;

    public function __construct(RatingCalculator $ratingCalculator)
    {
        $this->ratingCalculator = $ratingCalculator;
    }
    public function store(Request $request)
    {
        $this->validateStore($request);

        $overallwithDetails = $this->ratingCalculator->calculateOverallWithDetails(
            $request->input('cdr'),
            $request->input('rate')
        );


        return response()->json([
            "overall" => $overallwithDetails['overall'],
            "components" => [
                "energy" => $overallwithDetails['energy'],
                "time" => $overallwithDetails['time'],
                "transaction" => $overallwithDetails['transaction']
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
