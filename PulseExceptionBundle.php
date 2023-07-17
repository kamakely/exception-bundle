<?php
namespace Pulse\ExceptionBundle;

use Pulse\ExceptionBundle\DependencyInjection\Compiler\FormatRequestHandlerPass;
use Pulse\ExceptionBundle\DependencyInjection\Compiler\PulseListenerExceptionPass;
use Pulse\ExceptionBundle\DependencyInjection\Compiler\PulseLogicHandlerExceptionPass;
use Pulse\ExceptionBundle\DependencyInjection\PulseExceptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Pulse\ExceptionBundle\FormatResponse\FormatResponseInterface;

class PulseExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new PulseExceptionExtension());
        parent::build($container);
        $container->addCompilerPass(new PulseListenerExceptionPass());
        $container->addCompilerPass(new PulseLogicHandlerExceptionPass());
        $container->addCompilerPass(new FormatRequestHandlerPass());
        $container->registerForAutoconfiguration(PulseExceptionInterface::class)
            ->addTag('pulse_exception.handler');
        $container->registerForAutoconfiguration(FormatResponseInterface::class)
            ->addTag('pulse_exception.response');
    }
}
