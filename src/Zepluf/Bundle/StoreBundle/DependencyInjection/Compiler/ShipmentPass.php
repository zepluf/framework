<?php
namespace Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class ShipmentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('storebundle.shipping_methods')) {
            return;
        }

        $definition = $container->getDefinition(
            'storebundle.shipping_methods'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'storebundle.carrier'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addCarrier',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
}