<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Tounaf\Exception\Exception\ExceptionRegistry;
use Tounaf\Exception\FormatResponse\FormatResponseManager;
use Tounaf\Exception\FormatResponse\HtmlFormatResponse;
use Tounaf\Exception\FormatResponse\JsonFormatResponse;
use Tounaf\Exception\Handler\Generic\GeneraleLoggerExceptionHandler;
use Tounaf\ExceptionBundle\Negociation\FormatNegociator;
use Tounaf\ExceptionBundle\Listener\ExceptionListener;
use Tounaf\ExceptionBundle\Listener\FormatRequestListener;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(ExceptionRegistry::class)
            ->args([tagged_iterator('tounaf_exception.handler')])
        ->set(JsonFormatResponse::class)
            ->tag('tounaf_exception.response')
        ->set(HtmlFormatResponse::class)
            ->tag('tounaf_exception.response')
        ->set(FormatResponseManager::class)
        ->set(ExceptionListener::class)
            ->args([
                service(ExceptionRegistry::class),
                service(FormatResponseManager::class),
                param('tounaf_exception.debug')
            ])
            ->tag('kernel.event_listener', ['priority' => 200])
        ->set(FormatNegociator::class)
            ->args([
                service('request_stack')
            ])
        ->set(FormatRequestListener::class)
            ->args([
                service(FormatNegociator::class)
            ])
            ->tag('kernel.event_listener', ['priority' => 200])
        ->set(GeneraleLoggerExceptionHandler::class)
            ->autoconfigure(true)
            ->autowire(true)
    ;
};
