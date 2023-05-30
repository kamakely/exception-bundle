<?php
/**
 * Created by PhpStorm.
 * User: fetra
 * Date: 8/22/22
 * Time: 2:06 PM
 */

namespace Pulse\ExceptionBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

}



//
//class CoreExtension extends Extension implements PrependExtensionInterface
//{
//    public function load(array $configs, ContainerBuilder $container)
//    {
//        dump('ok');die;
//        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
//
//        $loader->load('services.yml');
//        dump($configs);die;
//    }
//
//    public function prepend(ContainerBuilder $container)
//    {
//        // TODO: Implement prepend() method.
//    }
//
//
//}
