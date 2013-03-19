<?php
namespace Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class StorePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false !== ($definition = $container->getDefinition('storebundle.payment_methods'))) {
            if (false !== ($taggedServices = $container->findTaggedServiceIds('storebundle.payment_methods.method'))) {
                foreach ($taggedServices as $id => $tagAttributes) {
                    foreach ($tagAttributes as $attributes) {
                        $definition->addMethodCall('addMethod',
                            array(new Reference($id), $attributes["alias"])
                        );
                    }
                }
            }
        }

        if (!$container->hasDefinition('storebundle.shipment')) {
            return;
        }

        $definition = $container->getDefinition(
            'storebundle.shipment'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'storebundle.shipment.carrier'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addCarriers',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
}