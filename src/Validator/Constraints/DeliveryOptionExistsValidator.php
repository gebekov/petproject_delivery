<?php

namespace App\Validator\Constraints;

use App\Delivery\DeliveryOptionManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DeliveryOptionExistsValidator extends ConstraintValidator
{
    public function __construct(
        private DeliveryOptionManager $deliveryOptionManager
    ) {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DeliveryOptionExists) {
            throw new UnexpectedTypeException($constraint, DeliveryOptionExists::class);
        }

        if ($value === null || $value === "") {
            return;
        }

        if (!$this->deliveryOptionManager->has($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
