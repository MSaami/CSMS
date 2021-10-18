<?php

namespace Tests\Unit;

use App\Services\RatingCalculator;
use Carbon\Carbon;
use TestCase;

class RateCalculatorTest extends TestCase
{
    private $ratingCalculator;

    public function setUp(): void
    {
        parent::setUp();
        $this->ratingCalculator = new RatingCalculator();
    }


    public function testCalculateEnergyReturnCorrectResultBasedOnArguments()
    {
        $result = $this->ratingCalculator->calculateEnergyRate(1204307, 1215230, 0.3);
        $this->assertEquals($result, 3.277);
    }

    public function testCalculateElpasedTimeReturnCorrectResultBasedOnArguments()
    {
        $startTime = Carbon::parse("2021-04-05T10:04:00Z");
        $stopTime = Carbon::parse("2021-04-05T11:27:00Z");

        $result = $this->ratingCalculator->calculateElpasedTimeRate($startTime, $stopTime, 2);
        $this->assertEquals($result, 2.767);

    }


    public function testCalculateOverallWithDetails()
    {
        $cdr = [
            "meterStart" => 1204307,
            "timestampStart" => "2021-04-05T10:04:00Z",
            "meterStop" => 1215230,
            "timestampStop" => "2021-04-05T11:27:00Z"
        ];

        $rate = [
            "energy" => 0.3,
            "time" => 2,
            "transaction" => 1
        ];

        $result = $this->ratingCalculator->calculateOverallWithDetails($cdr, $rate);

        $this->assertIsArray($result);

        $this->assertEquals($result, [
            "overall" => 7.04,
            "energy" => 3.277,
            "time" => 2.767,
            "transaction" => 1
        ]);
    }

}
