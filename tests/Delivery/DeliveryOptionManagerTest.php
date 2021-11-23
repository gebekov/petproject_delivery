<?php

namespace App\Tests\Delivery;

use App\Delivery\DeliveryOption\DeliveryOptionInterface;
use App\Delivery\DeliveryOptionManager;
use PHPUnit\Framework\TestCase;

class DeliveryOptionManagerTest extends TestCase
{
    private DeliveryOptionManager $manager;

    protected function setUp(): void
    {
        $deliveryOption = $this->createMock(DeliveryOptionInterface::class);
        $deliveryOption->method("getId")->willReturn("foo");

        $this->manager = new DeliveryOptionManager([$deliveryOption]);
    }

    public function testAdd()
    {
        $deliveryOption = $this->createMock(DeliveryOptionInterface::class);
        $deliveryOption->method("getId")->willReturn("bar");

        $this->manager->add($deliveryOption);

        $this->assertTrue($this->manager->has("foo"));
        $this->assertTrue($this->manager->has("bar"));
    }

    public function testAll()
    {
        $deliveryOptions = $this->manager->all();

        $this->assertCount(1, $deliveryOptions);
        $this->assertEquals("foo", $deliveryOptions[0]->getId());
    }

    public function testAllId()
    {
        $this->assertEquals(["foo"], $this->manager->allId());
    }

    public function testHas()
    {
        $this->assertTrue($this->manager->has("foo"));
        $this->assertFalse($this->manager->has("bar"));
    }

    public function testGet()
    {
        $this->assertNotNull($this->manager->get("foo"));
        $this->assertNull($this->manager->get("bar"));
    }
}
