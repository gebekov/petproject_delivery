<?php
namespace App\Dto;

use App\Validator\Constraints\DeliveryOptionExists;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CalculateDeliveryCostRequest
{
    public string $deliveryOption;
    public string $senderCity;
    public string $recipientCity;
    public array $parcels;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints(
            "deliveryOption",
            [new Optional(), new Type("string"), new DeliveryOptionExists()]
        );

        $metadata->addPropertyConstraints("senderCity", [new NotBlank(), new Type("string")]);
        $metadata->addPropertyConstraints("recipientCity", [new NotBlank(), new Type("string")]);
        $metadata->addPropertyConstraint(
            "parcels",
            new All(
                new Collection(
                    [
                        "width" => new Range(min: 0),
                        "height" => new Range(min: 0),
                        "length" => new Range(min: 0),
                        "weight" => new Range(min: 0)
                    ]
                )
            )
        );
    }
}
