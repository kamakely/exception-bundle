<?php

namespace Tounaf\ExceptionBundle\Exception;

interface DecoratorExceptionHandlerInterface extends ExceptionHandlerInterface
{
    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandler): void;
}
