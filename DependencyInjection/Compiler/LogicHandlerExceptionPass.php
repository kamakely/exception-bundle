<?php

namespace Tounaf\ExceptionBundle\DependencyInjection\Compiler;

use Tounaf\ExceptionBundle\Handler\LogicExceptionHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LogicHandlerExceptionPass implements CompilerPassInterface
{
    public const MESSAGE = 'Logical Exception';

    public function process(ContainerBuilder $container)
    {
        if($container->hasDefinition(LogicExceptionHandler::class)) {
            $definition = $container->getDefinition(LogicExceptionHandler::class);
            $definition->addArgument(self::MESSAGE);
        }
        
    }
}
