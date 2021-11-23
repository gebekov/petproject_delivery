<?php

namespace App\Tests\Delivery\DeliveryOption;

use App\Delivery\DeliveryOption\ExpressDeliveryOption;
use App\Delivery\Parcel;
use App\Delivery\Position;
use App\Service\Distance;
use PHPUnit\Framework\TestCase;

class ExpressDeliveryOptionTest extends TestCase
{
    public function testCalculate(): void
    {
        $mockDistance = $this->createMock(Distance::class);
        $mockDistance->method("calculate")->willReturn(1195474.305106778);

        $parcels = [
            new Parcel(10, 35, 35, 1)
        ];

        $sender = new Position(0, 0);
        $recipient = new Position(0, 0);

        $deliveryOption = new ExpressDeliveryOption($mockDistance);
        $cost = $deliveryOption->calculateCost($parcels, $sender, $recipient);

        $this->assertEquals(673.59920814485, $cost);
    }
}
