<?php

namespace App\Tests\Delivery\DeliveryOption;

use App\Delivery\DeliveryOption\KrasnodarDeliveryOption;
use App\Delivery\Exception\CostCalculationException;
use App\Delivery\Parcel;
use App\Delivery\Position;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Service\Distance;
use PHPUnit\Framework\TestCase;

class KrasnodarDeliveryOptionTest extends TestCase
{
    public function testCalculate(): void
    {
        $mockDistance = $this->createMock(Distance::class);
        $mockDistance->method("calculate")->willReturn(0.0);

        $parcels = [
            new Parcel(10, 35, 35, 1)
        ];

        $sender = new Position(0, 0);
        $recipient = new Position(0, 0);

        $city = new City();
        $city->longitude = 0;
        $city->latitude = 0;

        $cityRepository = $this->createMock(CityRepository::class);
        $cityRepository->method("find")->willReturn($city);

        $deliveryOption = new KrasnodarDeliveryOption($cityRepository, $mockDistance);
        $cost = $deliveryOption->calculateCost($parcels, $sender, $recipient);

        $this->assertEquals(172.5, $cost);
    }
    public function testCalculateWithError(): void
    {
        $mockDistance = $this->createMock(Distance::class);
        $mockDistance->method("calculate")->willReturn(40000.0);

        $parcels = [
            new Parcel(10, 35, 35, 1)
        ];

        $sender = new Position(0, 0);
        $recipient = new Position(0, 0);

        $city = new City();
        $city->longitude = 0;
        $city->latitude = 0;

        $cityRepository = $this->createMock(CityRepository::class);
        $cityRepository->method("find")->willReturn($city);

        $deliveryOption = new KrasnodarDeliveryOption($cityRepository, $mockDistance);

        $this->expectException(CostCalculationException::class);
        $this->expectExceptionMessage("Too long delivery distance");

        $deliveryOption->calculateCost($parcels, $sender, $recipient);
    }
}
