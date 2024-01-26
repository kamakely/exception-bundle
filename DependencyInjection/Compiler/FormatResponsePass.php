<?php

namespace Tounaf\ExceptionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;
use Tounaf\ExceptionBundle\FormatResponse\JsonFormatResponse;

class FormatResponsePass implements CompilerPassInterface
{
    
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition(FormatResponseInterface::class)) {
            return;
        }
        
        $container->setAlias(FormatResponseInterface::class, JsonFormatResponse::class);   
    }
}
