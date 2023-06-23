<?php

namespace Pulse\ExceptionBundle\DependencyInjection\Compiler;

use Pulse\ExceptionBundle\Handler\PulseLogicExceptionHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PulseLogicHandlerExceptionPass implements CompilerPassInterface
{
    public const MESSAGE = 'Logica Exception';

    public function process(ContainerBuilder $container)
    {
        if($container->hasDefinition(PulseLogicExceptionHandler::class)) {
            $definition = $container->getDefinition(PulseLogicExceptionHandler::class);
            $definition->addArgument(self::MESSAGE);
        }
        
    }
}
