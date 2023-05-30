<?php
namespace Pulse\ExceptionBundle;

use Pulse\ExceptionBundle\DependencyInjection\CoreExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Pulse\ExceptionBundle\Exception\PosExceptionInterface;

class PulseExceptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->registerExtension(new CoreExtension());
        parent::build($container);
        $container->registerForAutoconfiguration(PosExceptionInterface::class)
            ->addTag('pos.core_exception');
    }
}
