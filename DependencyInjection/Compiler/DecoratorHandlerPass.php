<?php

namespace Tounaf\ExceptionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tounaf\Exception\Exception\ExceptionRegistry;

class DecoratorHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition(ExceptionRegistry::class)) {
            return;
        }

        $taggedDecoratorDefinitions = $container->findTaggedServiceIds('tounaf_exception.decorator_hander');
        $exceptionRegistryDefinition = $container->findDefinition(ExceptionRegistry::class);
        foreach(array_keys($taggedDecoratorDefinitions) as $serviceId) {
            $service = $container->findDefinition($serviceId);
            $exceptionRegistryDefinition->addMethodCall('addDecorator', [$service]);
        }

    }
}
