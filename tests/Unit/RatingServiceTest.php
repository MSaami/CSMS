<?php

namespace Tests\Unit;

use App\Services\RatingService;
use Carbon\Carbon;
use TestCase;

class RatingServiceTest extends TestCase
{
    private $ratingService;

    public function setUp(): void
    {
        parent::setUp();
        $this->ratingService = new RatingService();
    }


    public function testCalculateEnergyReturnCorrectResultBasedOnArguments()
    {
        $result = $this->ratingService->calculateEnergyRate(1204307, 1215230, 0.3);
        $this->assertEquals($result, 3.277);
    }

    public function testCalculateElpasedTimeReturnCorrectResultBasedOnArguments()
    {
        $startTime = Carbon::parse("2021-04-05T10:04:00Z");
        $stopTime = Carbon::parse("2021-04-05T11:27:00Z");

        $result = $this->ratingService->calculateElpasedTimeRate($startTime, $stopTime, 2);
        $this->assertEquals($result, 2.767);

    }


}
