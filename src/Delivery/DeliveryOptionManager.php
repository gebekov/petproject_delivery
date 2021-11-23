<?php

namespace App\Delivery;

use App\Delivery\DeliveryOption\DeliveryOptionInterface;

class DeliveryOptionManager
{
    /**
     * DeliveryOptionManager constructor.
     * @param DeliveryOptionInterface[] $deliveryOptions
     */
    public function __construct(
        protected array $deliveryOptions = []
    ) {
    }

    public function add(DeliveryOptionInterface $deliveryOption): void
    {
        $this->deliveryOptions[] = $deliveryOption;
    }

    /**
     * @return DeliveryOptionInterface[]
     */
    public function all(): array
    {
        return $this->deliveryOptions;
    }

    /**
     * @return string[]
     */
    public function allId(): array
    {
        $id = [];

        foreach ($this->deliveryOptions as $deliveryOption) {
            $id[] = $deliveryOption->getId();
        }

        return $id;
    }

    public function has(string $id): bool
    {
        foreach ($this->deliveryOptions as $deliveryOption) {
            if ($deliveryOption->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function get(string $id): ?DeliveryOptionInterface
    {
        foreach ($this->deliveryOptions as $deliveryOption) {
            if ($deliveryOption->getId() == $id) {
                return $deliveryOption;
            }
        }

        return null;
    }
}
