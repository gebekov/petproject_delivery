<?php

namespace App\Delivery\DeliveryOption;

use App\Delivery\Position;
use App\Service\Distance;

class SuperExpressDeliveryOption implements DeliveryOptionInterface
{
    public function __construct(
        private Distance $distance
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return "Супер-экспресс";
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): string
    {
        return "super-express";
    }

    /**
     * {@inheritDoc}
     */
    public function calculateCost(
        array $parcels,
        Position $sender,
        Position $recipient
    ): float {
        $weightCost = 0;

        foreach ($parcels as $parcel) {
            $weightCost += max($parcel->weight, $parcel->getVolumeWeight()) * 50;
        }

        $distance = $this->distance->calculate(
            $sender->latitude,
            $sender->longitude,
            $recipient->latitude,
            $recipient->longitude
        );

        return ($weightCost + $distance / 1000 * 0.3) * 1.6;
    }
}
