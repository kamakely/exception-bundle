<?php

namespace Tounaf\ExceptionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Tounaf\Exception\FormatResponse\FormatResponseInterface;
use Tounaf\Exception\FormatResponse\JsonFormatResponse;

class TounafExceptionExtension extends Extension
{
    public const FORMATS = ['json', 'html'];

    public function load(array $configs, ContainerBuilder $container)
    {

        $loaderPhp = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loaderPhp->load('tounaf_exception.php');

        $loaderXml = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loaderXml->load('services.xml');

        $container->setAlias(FormatResponseInterface::class, JsonFormatResponse::class);

        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('tounaf_exception.debug', $config['debug']);
        $container->setParameter('tounaf_exception.format_handlers', $config['format_handlers']);
    }
}
