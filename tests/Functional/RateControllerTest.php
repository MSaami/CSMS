<?php


class RateControllerTest extends TestCase
{
    public function testCanSendCdrAndReturnOverallResponse()
    {
        $this->json('post', '/api/v1/rate', [
            "rate" => [
                "energy" => 0.3,
                "time" => 2,
                "transaction" => 1
            ],
            "cdr" => [
                "meterStart" => 1204307,
                "timestampStart" => "2021-04-05T10:04:00Z",
                "meterStop" => 1215230,
                "timestampStop" => "2021-04-05T11:27:00Z"
            ]
        ])->seeJson([
            "overall" => 7.04,
            "components" => [
                "energy" => 3.277,
                "time" => 2.767,
                "transaction" => 1
            ]
        ]);

    }
}
