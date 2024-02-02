<?php

namespace Tounaf\ExceptionBundle\Handler\Generic;

use Psr\Log\LoggerInterface;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Tounaf\ExceptionBundle\Exception\DecoratorExceptionHandlerInterface;
use Tounaf\ExceptionBundle\Exception\TounafException;

class GeneraleLoggerExceptionHandler implements DecoratorExceptionHandlerInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    private ExceptionHandlerInterface $decoratedExceptionHandlerInterface;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @param  \Throwable $throwable
     * @return array|string
     */
    public function handleException(\Throwable $throwable): Response
    {
        if ($throwable instanceof HttpExceptionInterface || $throwable->getStatusCode() >= 500) {
            $this->logger->critical(
                $throwable->getMessage(),
                ['exception' => $throwable]
            );
        } else {
            $this->logger->error(
                $throwable->getMessage(),
                ['exception' => $throwable]
            );
        }

        return $this->decoratedExceptionHandlerInterface->handleException($throwable);
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof TounafException;
    }

    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandlerInterface): void
    {
        $this->decoratedExceptionHandlerInterface = $decoratedExceptionHandlerInterface;
    }

}
