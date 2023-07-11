<?php
namespace Pulse\ExceptionBundle;

use Pulse\ExceptionBundle\DependencyInjection\Compiler\PulseListenerExceptionPass;
use Pulse\ExceptionBundle\DependencyInjection\Compiler\PulseLogicHandlerExceptionPass;
use Pulse\ExceptionBundle\DependencyInjection\PulseExceptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new PulseExceptionExtension());
        parent::build($container);
        $container->addCompilerPass(new PulseListenerExceptionPass());
        $container->addCompilerPass(new PulseLogicHandlerExceptionPass());
        $container->registerForAutoconfiguration(PulseExceptionInterface::class)
            ->addTag('pulse.exception');
    }
}
