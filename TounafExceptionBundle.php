<?php

namespace Tounaf\ExceptionBundle;

use Tounaf\ExceptionBundle\DependencyInjection\Compiler\FormatRequestHandlerPass;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\ListenerExceptionPass;
use Tounaf\ExceptionBundle\DependencyInjection\TounafExceptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\DecoratorHandlerPass;
use Tounaf\Exception\Exception\ExceptionHandlerInterface;
use Tounaf\Exception\Exception\DecoratorExceptionHandlerInterface;
use Tounaf\Exception\FormatResponse\FormatResponseInterface;

class TounafExceptionBundle extends Bundle
{
    /**
     * @return
     */
    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new TounafExceptionExtension());
        parent::build($container);

        $container->addCompilerPass(new ListenerExceptionPass());
        $container->addCompilerPass(new FormatRequestHandlerPass());
        $container->addCompilerPass(new DecoratorHandlerPass());

        $container->registerForAutoconfiguration(ExceptionHandlerInterface::class)
            ->addTag('tounaf_exception.handler');
        $container->registerForAutoconfiguration(FormatResponseInterface::class)
            ->addTag('tounaf_exception.response');
        $container->registerForAutoconfiguration(DecoratorExceptionHandlerInterface::class)
            ->addTag('tounaf_exception.decorator_hander');
    }
}
