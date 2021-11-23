<?php

namespace App\Delivery;

class Position
{
    public function __construct(
        public float $longitude,
        public float $latitude
    ) {}
}
