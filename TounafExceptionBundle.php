<?php
namespace Tounaf\ExceptionBundle;

use Tounaf\ExceptionBundle\DependencyInjection\Compiler\FormatRequestHandlerPass;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\ListenerExceptionPass;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\LogicHandlerExceptionPass;
use Tounaf\ExceptionBundle\DependencyInjection\ExceptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tounaf\ExceptionBundle\Exception\ExceptionInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class TounafExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new ExceptionExtension());
        parent::build($container);
        $container->addCompilerPass(new ListenerExceptionPass());
        $container->addCompilerPass(new LogicHandlerExceptionPass());
        $container->addCompilerPass(new FormatRequestHandlerPass());
        $container->registerForAutoconfiguration(ExceptionInterface::class)
            ->addTag('tounaf_exception.handler');
        $container->registerForAutoconfiguration(FormatResponseInterface::class)
            ->addTag('tounaf_exception.response');
    }
}
