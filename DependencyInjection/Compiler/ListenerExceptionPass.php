<?php

namespace Tounaf\ExceptionBundle\DependencyInjection\Compiler;


use Tounaf\ExceptionBundle\Listener\ExceptionListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ListenerExceptionPass implements CompilerPassInterface
{
    
    public function process(ContainerBuilder $container)
    {    
        if($container->hasParameter('tounaf_exception.debug')) {
            $definition = $container->getDefinition(ExceptionListener::class);
            $definition->setArgument(2, $container->getParameter('tounaf_exception.debug'));
        }
    }
}
