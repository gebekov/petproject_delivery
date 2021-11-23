<?php

namespace App\Transformer;

use App\Delivery\Position;
use App\Entity\City;

class PositionTransformer
{
    public static function transform(array $data): Position
    {
        return new Position($data["longitude"], $data["latitude"]);
    }

    public static function transformFromCity(City $city): Position
    {
        return new Position($city->longitude, $city->latitude);
    }
}
