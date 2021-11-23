<?php

namespace App\Delivery\DependencyInjection;

use App\Delivery\DeliveryOptionManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DeliveryOptionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(DeliveryOptionManager::class)) {
            return;
        }

        $definition = $container->findDefinition(DeliveryOptionManager::class);
        $taggedCalculations = $container->findTaggedServiceIds("delivery.delivery_options");

        foreach (array_keys($taggedCalculations) as $id) {
            $definition->addMethodCall("add", [new Reference($id)]);
        }
    }
}
