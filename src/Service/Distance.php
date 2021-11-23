<?php

namespace App\Service;

/**
 * Компонент для расчета расстояний на сфере
 */
class Distance
{
    /**
     * Расчет расстояния на карте по формуле Хаверсина.
     * @param float $lat1
     * @param float $long1
     * @param float $lat2
     * @param float $long2
     * @return float
     */
    public function calculate(
        float $lat1,
        float $long1,
        float $lat2,
        float $long2
    ): float {
        //радиус Земли
        $R = 6372795;

        //перевод координат в радианы
        $lat1 *= pi() / 180;
        $lat2 *= pi() / 180;
        $long1 *= pi() / 180;
        $long2 *= pi() / 180;

        //вычисление косинусов и синусов широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cDelta = cos($delta);
        $sDelta = sin($delta);

        //вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sDelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cDelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cDelta;
        $ad = atan2($y, $x);

        //расстояние между двумя координатами в метрах
        return $ad * $R;
    }
}
