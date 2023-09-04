<?php

namespace Tounaf\ExceptionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class TounafExceptionExtension extends Extension
{
    const FORMATS = ['json', 'html'];

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('tounaf_exception.debug', $config['debug']);
        $container->setParameter('tounaf_exception.format_handlers', $config['format_handlers']);
        
    }
}
