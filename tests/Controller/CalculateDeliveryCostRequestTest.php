<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculateDeliveryCostRequestTest extends WebTestCase
{
    public function testSomething(): void
    {
        $body = [
            "deliveryOption" => "super-express",
            "senderCity" => "7dfa745e-aa19-4688-b121-b655c11e482f",
            "recipientCity" => "0c5b2444-70a0-4932-980c-b4dc0d3f02b5",
            "parcels" => [
                [
                    "width" => 35,
                    "height" => 35,
                    "length" => 10,
                    "weight" => 1
                ]
            ],
        ];

        $client = static::createClient();
        $client->catchExceptions(false);
        $client->request(
            'POST',
            '/calculate',
            server: ["CONTENT_TYPE" => "application/json"],
            content: json_encode($body)
        );

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }
}
