<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Модель города с его географическим положением
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 * @ORM\Table(name="cities")
 */
class City
{
    /**
     * @var string идентификатор (ФИАС)
     * @ORM\Id()
     * @ORM\Column(name="id", type="string", length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    public string $id;

    /**
     * @var string почтовый код
     * @ORM\Column(name="postal_code", type="string")
     */
    public string $postalCode;

    /**
     * @var string название города
     * @ORM\Column(name="name", type="string")
     */
    public string $name;

    /**
     * @var float позиция города - широта
     * @ORM\Column(name="latitude", type="float")
     */
    public float $latitude;

    /**
     * @var float позиция города - долгота
     * @ORM\Column(name="longitude", type="float")
     */
    public float $longitude;
}
