<?php

namespace App\Transformer;

use App\Delivery\Parcel;

class ParcelTransformer
{
    public static function transform(array $data): Parcel
    {
        return new Parcel($data["length"], $data["width"], $data["height"], $data["weight"]);
    }

    /**
     * @param array $data
     * @return Parcel[]
     */
    public static function transformCollection(array $data): array
    {
        $result = [];

        foreach ($data as $item) {
            $result[] = static::transform($item);
        }

        return $result;
    }

}
