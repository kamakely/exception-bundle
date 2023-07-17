<?php

namespace Pulse\ExceptionBundle\DependencyInjection\Compiler;

use Pulse\ExceptionBundle\FormatResponse\FormatResponseManager;
use Pulse\ExceptionBundle\Negociation\FormatNegociator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\RequestMatcher;

class FormatRequestHandlerPass implements CompilerPassInterface
{
    
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition(FormatNegociator::class)) {
            return;
        }
        
        $rules = $container->getParameter('pulse_exception.format_handlers');
        foreach ($rules as $rule) {
            $this->addRule($rule, $container);
        }

        $taggedDefinitions = $container->findTaggedServiceIds('pulse_exception.response');
        $manager = $container->findDefinition(FormatResponseManager::class);
        foreach($taggedDefinitions as $serviceId => $tagged) {
            $service = $container->findDefinition($serviceId);
            $manager->addMethodCall('addFormatResponse', [$service]);
        }
        
    }

    private function addRule(array $rule, ContainerBuilder $container): void
    {
        $matcher = $this->createRequestMatcher(
            $container,
            $rule['path'],
            $rule['host'],
            $rule['methods'],
            $rule['attributes']
        );

        unset($rule['path'], $rule['host']);
        $container->getDefinition(FormatNegociator::class)
            ->addMethodCall('add', [$matcher, $rule]);
    }

    private function createRequestMatcher(ContainerBuilder $container, ?string $path = null, ?string $host = null, ?array $methods = null, array $attributes = []): Reference
    {
        $arguments = [$path, $host, $methods, null, $attributes];
        $serialized = serialize($arguments);
        $id = 'pulse_exception.request_matcher.'.md5($serialized).sha1($serialized);

        if (!$container->hasDefinition($id)) {
            $container->setDefinition($id, new Definition(RequestMatcher::class, $arguments));
        }

        return new Reference($id);
    }
}
