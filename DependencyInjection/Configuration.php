<?php

namespace Tounaf\ExceptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('tounaf_exception');
        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('debug')->defaultFalse()->end()
                ->arrayNode('format_handlers')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('path')->end()
                            ->scalarNode('host')->defaultNull()->end()
                            ->scalarNode('methods')->defaultValue([])->end()
                            ->scalarNode('attributes')->defaultValue([])->end()
                            ->scalarNode('format')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
