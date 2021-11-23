<?php

namespace App\Delivery\DeliveryOption;

use App\Delivery\Exception\CostCalculationException;
use App\Delivery\Position;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Service\Distance;

class KrasnodarDeliveryOption implements DeliveryOptionInterface
{
    public const CITY_ID = "7dfa745e-aa19-4688-b121-b655c11e482f";
    public const RADIUS = 30000;

    /**
     * ByCityCalculation constructor.
     * @param CityRepository $cityRepository
     * @param Distance $distance
     */
    public function __construct(
        private CityRepository $cityRepository,
        private Distance $distance,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return "По Краснодару";
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): string
    {
        return "by-krasnodar";
    }

    /**
     * {@inheritDoc}
     */
    public function calculateCost(
        array $parcels,
        Position $sender,
        Position $recipient
    ): float {
        $city = $this->cityRepository->find(self::CITY_ID);

        if (empty($city)) {
            throw new CostCalculationException("City not found");
        }

        if (
            $this->distance($sender, $city) > self::RADIUS ||
            $this->distance($recipient, $city) > self::RADIUS
        ) {
            throw new CostCalculationException("Too long delivery distance");
        }

        $weight = 0;
        foreach ($parcels as $parcel) {
            $weight += $parcel->weight + $parcel->getVolumeWeight();
        }

        return $weight * 50;
    }

    private function distance(Position $position, City $city): float
    {
        return $this->distance->calculate(
            $position->latitude,
            $position->longitude,
            $city->latitude,
            $city->longitude
        );
    }

}
