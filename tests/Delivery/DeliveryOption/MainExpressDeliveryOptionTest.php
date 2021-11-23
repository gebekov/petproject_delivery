<?php

namespace App\Tests\Delivery\DeliveryOption;

use App\Delivery\DeliveryOption\MainExpressDeliveryOption;
use App\Delivery\Parcel;
use App\Delivery\Position;
use App\Service\Distance;
use PHPUnit\Framework\TestCase;

class MainExpressDeliveryOptionTest extends TestCase
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

        $deliveryOption = new MainExpressDeliveryOption($mockDistance);
        $cost = $deliveryOption->calculateCost($parcels, $sender, $recipient);

        $this->assertEquals(577.37074983844, $cost);
    }
}
