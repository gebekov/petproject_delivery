<?php

namespace App\Delivery;

class Parcel
{
    public function __construct(
        public float $length,
        public float $width,
        public float $height,
        public float $weight
    ) {}

    public function getVolumeWeight(): float
    {
        return ($this->length * $this->width * $this->height) / 5000;
    }
}
