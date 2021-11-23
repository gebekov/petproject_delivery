<?php

namespace App\Controller;

use App\Delivery\DeliveryOptionManager;
use App\Delivery\Exception\CostCalculationException;
use App\Dto\CalculateDeliveryCostRequest;
use App\Repository\CityRepository;
use App\Transformer\ParcelTransformer;
use App\Transformer\PositionTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route(path: "/calculate", methods: ["POST"])]
class CalculateDeliveryCostAction
{
    use ResponsesTrait;

    public function __construct(
        private DeliveryOptionManager $deliveryOptionManager,
        private CityRepository $cityRepository
    ) {
    }

    #[ParamConverter("data", converter: "fos_rest.request_body")]
    public function __invoke(CalculateDeliveryCostRequest $data, ConstraintViolationListInterface $validationErrors): Response
    {
        if (count($validationErrors) > 0) {
            return $this->validationError($validationErrors);
        }

        $parcels = ParcelTransformer::transformCollection($data->parcels);

        $deliveryOption = $this->deliveryOptionManager->get($data->deliveryOption);

        $senderCity = $this->cityRepository->find($data->senderCity);
        $recipientCity = $this->cityRepository->find($data->recipientCity);

        $sender = PositionTransformer::transformFromCity($senderCity);
        $recipient = PositionTransformer::transformFromCity($recipientCity);

        try {
            $cost = $deliveryOption->calculateCost($parcels, $sender, $recipient);
        } catch (CostCalculationException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $this->ok(["cost" => $cost]);
    }
}
