<?php

namespace App\Controller;

use App\Delivery\DeliveryOptionManager;
use App\Delivery\Exception\CostCalculationException;
use App\Dto\CalculateAllDeliveriesCostRequest;
use App\Repository\CityRepository;
use App\Transformer\ParcelTransformer;
use App\Transformer\PositionTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route(path: "/calculate-all", methods: ["POST"])]
class CalculateAllDeliveriesCostAction
{
    use ResponsesTrait;

    public function __construct(
        private DeliveryOptionManager $deliveryOptionManager,
        private CityRepository $cityRepository
    ) {
    }

    #[ParamConverter("data", converter: "fos_rest.request_body")]
    public function __invoke(
        CalculateAllDeliveriesCostRequest $data,
        ConstraintViolationListInterface $validationErrors
    ): Response {
        if (count($validationErrors) > 0) {
            return $this->validationError($validationErrors);
        }

        $parcels = ParcelTransformer::transformCollection($data->parcels);

        $senderCity = $this->cityRepository->find($data->senderCity);
        $recipientCity = $this->cityRepository->find($data->recipientCity);

        $sender = PositionTransformer::transformFromCity($senderCity);
        $recipient = PositionTransformer::transformFromCity($recipientCity);

        $result = [];

        foreach ($this->deliveryOptionManager->all() as $deliveryOption) {
            $item = [
                "deliveryOption" => $deliveryOption->getId(),
                "cost" => 0
            ];

            try {
                $cost = $deliveryOption->calculateCost($parcels, $sender, $recipient);

                $item["cost"] = $cost;
            } catch (CostCalculationException $e) {
                $item["error"] = $e->getMessage();
            }

            $result[] = $item;
        }

        return $this->ok($result);
    }
}
