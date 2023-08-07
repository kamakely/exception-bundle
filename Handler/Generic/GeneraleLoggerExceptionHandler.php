<?php

namespace Tounaf\ExceptionBundle\Handler\Generic;

use Psr\Log\LoggerInterface;
use Tounaf\ExceptionBundle\Exception\Exception;
use Tounaf\ExceptionBundle\Exception\ExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\Exception\TounafException;

class GeneraleLoggerExceptionHandler implements ExceptionInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;
    public function __construct(private ExceptionInterface $exceptionInterface, LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @param  \Throwable $throwable
     * @return array|string
     */
    public function handleException(\Throwable $throwable): Response
    {
        $this->logger->notice(" --- PULSE: L'ERREUR SUIVANTE EST LEVÉE PAR POS ---");
        $this->logger->error(sprintf('--- PULSE: CAUSE: %s', $throwable->getMessage()));
        $this->logger->error(sprintf('--- PULSE: FILE: %s', $throwable->getFile()));
        $this->logger->error(sprintf('--- PULSE: LINE: %s', $throwable->getLine()));
        $this->logger->error(sprintf('--- PULSE: TRACE: %s', $throwable->getTraceAsString()));
        return $this->exceptionInterface->handleException($throwable);
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof TounafException;
    }

}
