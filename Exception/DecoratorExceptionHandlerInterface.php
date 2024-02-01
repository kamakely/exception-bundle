<?php

namespace Tounaf\ExceptionBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

interface DecoratorExceptionHandlerInterface
{
    /**
     * @param  \Throwable $throwable
     * @return Response
     */
    public function handleException(\Throwable $throwable): Response;

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandler): void;
}
