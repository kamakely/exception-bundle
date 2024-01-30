<?php

namespace Tounaf\ExceptionBundle\Handler\Generic;

use Psr\Log\LoggerInterface;
use Tounaf\ExceptionBundle\Exception\Exception;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\Exception\TounafException;

class GeneraleLoggerExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    public function __construct(private ExceptionHandlerInterface $exceptionHandlerInterface, LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @param  \Throwable $throwable
     * @return array|string
     */
    public function handleException(\Throwable $throwable): Response
    {
        $this->logger->notice(
            sprintf("This notice is provided by tounaf/exception-bundle")
        );

        return $this->exceptionHandlerInterface->handleException($throwable);
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof TounafException;
    }

}
