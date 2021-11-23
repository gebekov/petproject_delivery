<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[Attribute]
class DeliveryOptionExists extends Constraint
{
    public string $message = "Delivery option does not exist";
}
