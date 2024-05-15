<?php

namespace Tounaf\ExceptionBundle\DependencyInjection;

use LogicException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Tounaf\Exception\Exception\ExceptionHandlerInterface;
use Tounaf\Exception\Exception\ExceptionRegistry;
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
        $exceptionRegistryDefinition = $container->findDefinition(ExceptionRegistry::class);
        
        $defaultHandler = $config['default_handler'];

        if(!class_exists($defaultHandler) || !is_a($defaultHandler, ExceptionHandlerInterface::class, true)) {
            throw new LogicException(sprintf('The value "%s" of key %s must be a valid class and implement %s interface .', $defaultHandler, 'tounaf_exception.default_handler', ExceptionHandlerInterface::class));
        }

        $defaultHandlerDefinition = $container->setDefinition('default_handler', new Definition($defaultHandler));
        $exceptionRegistryDefinition->addMethodCall('setDefaultHandler', [$defaultHandlerDefinition]);
    }
}
