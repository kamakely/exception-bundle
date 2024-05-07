<?php

namespace Tounaf\ExceptionBundle\DependencyInjection\Compiler;

use Tounaf\Exception\FormatResponse\FormatResponseManager;
use Tounaf\ExceptionBundle\Negociation\FormatNegociator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\ChainRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\AttributesRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class FormatRequestHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition(FormatNegociator::class)) {
            return;
        }
        $htmlRules = [
            "path" => "/",
            "format" => "html",
            "host" => "",
            "methods" => [],
            "attributes" => []
        ];

        $jsonRules = [
            "path" => "/api/",
            "format" => "json",
            "host" => "",
            "methods" => [],
            "attributes" => []
        ];

        $rules = $container->getParameter('tounaf_exception.format_handlers');
        foreach ($rules as $rule) {
            $this->addRule($rule, $container);
        }

        $this->addRule($jsonRules, $container);
        $this->addRule($htmlRules, $container);

        if (!$container->hasDefinition(FormatResponseManager::class)) {
            return;
        }

        $taggedDefinitions = $container->findTaggedServiceIds('tounaf_exception.response');
        $manager = $container->findDefinition(FormatResponseManager::class);
        foreach(array_keys($taggedDefinitions) as $serviceId) {
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

    private function createRequestMatcher(ContainerBuilder $container, ?string $path = null, ?string $host = null, ?array $methods = [], array $attributes = []): Reference
    {
        if (!class_exists(ChainRequestMatcher::class)) {
            $arguments = [$path, $host, $methods, $attributes];
            return $this->createReferenceMatcher(new RequestMatcher($path, $host, $methods, $attributes), $container, 'chain', $arguments);
        }

        $pathReferenceMatcher = $this->createReferenceMatcher(new PathRequestMatcher($path), $container, 'path', [$path]);
        $methodsReferenceMatcher = $this->createReferenceMatcher(new MethodRequestMatcher($methods), $container, 'methods', [$methods]);
        $attributesReferenceMatcher = $this->createReferenceMatcher(new AttributesRequestMatcher($attributes), $container, 'attributes', [$attributes]);
        $arguments = [$pathReferenceMatcher, $methodsReferenceMatcher, $attributesReferenceMatcher];

        return $this->createReferenceMatcher(new ChainRequestMatcher($arguments), $container, 'chain', [$arguments]);
    }

    private function createReferenceMatcher(RequestMatcherInterface $requestMatcherInterface, ContainerBuilder $container, string $matchable, array $arguments)
    {
        $serialized = serialize($arguments);
        $id = 'tounaf_exception.' .$matchable .'_matcher.'.md5($serialized).sha1($serialized);

        if (!$container->hasDefinition($id)) {
            $container->setDefinition($id, new Definition(get_class($requestMatcherInterface), $arguments));
        }

        return new Reference($id);
    }
}
