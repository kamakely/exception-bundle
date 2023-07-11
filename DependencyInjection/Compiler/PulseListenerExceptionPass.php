<?php

namespace Pulse\ExceptionBundle\DependencyInjection\Compiler;

use Pulse\ExceptionBundle\Handler\PulseLogicExceptionHandler;
use Pulse\ExceptionBundle\Listener\PulseExceptionListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PulseListenerExceptionPass implements CompilerPassInterface
{
    
    public function process(ContainerBuilder $container)
    {
        
        if($container->hasParameter('pulse_exception.debug')) {
            $definition = $container->getDefinition(PulseExceptionListener::class);
            $definition->setArgument(1, $container->getParameter('pulse_exception.debug'));
        }

    }
}
