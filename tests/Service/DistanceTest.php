<?php

namespace App\Tests\Service;

use App\Service\Distance;
use PHPUnit\Framework\TestCase;

class DistanceTest extends TestCase
{
    /**
     * @dataProvider calculateProvider
     * @param float $lat1
     * @param float $long1
     * @param float $lat2
     * @param float $long2
     * @param float $actual
     */
    public function testCalculate(float $lat1, float $long1, float $lat2, float $long2, float $actual): void
    {
        $svc = new Distance();

        $this->assertEquals(
            $svc->calculate($lat1, $long1, $lat2, $long2),
            $actual
        );
    }

    public function calculateProvider(): array
    {
        return [
            [44.878414, 39.190289, 44.6098268, 40.1006606, 77875.94622665967],
            [55.7540471, 37.620405, 45.0401604, 38.9759647, 1195474.305106778],
            [55.7540471, 37.620405, 55.7943584, 49.1114975, 718070.3911947592],
            [55.7540471, 37.620405, 55.7540471, 37.620405, 0],
        ];
    }
}
