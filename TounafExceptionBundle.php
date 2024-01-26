<?php
namespace Tounaf\ExceptionBundle;

use Tounaf\ExceptionBundle\DependencyInjection\Compiler\FormatRequestHandlerPass;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\ListenerExceptionPass;
use Tounaf\ExceptionBundle\DependencyInjection\TounafExceptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tounaf\ExceptionBundle\DependencyInjection\Compiler\FormatResponsePass;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class TounafExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new TounafExceptionExtension());
        parent::build($container);

        $container->addCompilerPass(new FormatResponsePass());
        $container->addCompilerPass(new ListenerExceptionPass());
        $container->addCompilerPass(new FormatRequestHandlerPass());
        
        $container->registerForAutoconfiguration(ExceptionHandlerInterface::class)
            ->addTag('tounaf_exception.handler');
        $container->registerForAutoconfiguration(FormatResponseInterface::class)
            ->addTag('tounaf_exception.response');
    }
}
