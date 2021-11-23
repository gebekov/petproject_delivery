<?php

namespace App\Delivery\DeliveryOption;

use App\Delivery\Exception\CostCalculationException;
use App\Delivery\Parcel;
use App\Delivery\Position;

interface DeliveryOptionInterface
{
    /**
     * Возвращает название варианта доставки
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает идентификатор варианта доставки
     * @return string
     */
    public function getId(): string;

    /**
     * Рассчитывает стоимость доставки
     * @param Parcel[] $parcels
     * @param Position $sender
     * @param Position $recipient
     * @return float
     * @throws CostCalculationException
     */
    public function calculateCost(
        array $parcels,
        Position $sender,
        Position $recipient
    ): float;
}
