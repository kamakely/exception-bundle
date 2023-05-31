<?php
namespace Pulse\ExceptionBundle;

use Pulse\ExceptionBundle\DependencyInjection\CoreExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new CoreExtension());
        parent::build($container);
        $container->registerForAutoconfiguration(PulseExceptionInterface::class)
            ->addTag('pulse.core_exception');
    }
}
