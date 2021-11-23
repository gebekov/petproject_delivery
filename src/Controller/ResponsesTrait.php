<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ResponsesTrait
{
    private function validationError(ConstraintViolationListInterface $violationList): JsonResponse
    {
        $constraintViolationListNormalizer = new ConstraintViolationListNormalizer();

        try {
            $normalizedValidationErrors = $constraintViolationListNormalizer->normalize($violationList);
        } catch (ExceptionInterface) {
            return new JsonResponse(status: 500);
        }

        return new JsonResponse($normalizedValidationErrors, 400);
    }

    private function ok(mixed $data): JsonResponse
    {
        return new JsonResponse($data, 200);
    }
}
