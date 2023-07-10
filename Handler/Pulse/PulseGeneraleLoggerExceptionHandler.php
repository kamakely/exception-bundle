<?php

namespace Pulse\ExceptionBundle\Handler\Pulse;

use Psr\Log\LoggerInterface;
use Pulse\ExceptionBundle\Exception\PulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class PulseGeneraleLoggerExceptionHandler implements PulseExceptionInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;
    public function __construct(private PulseExceptionInterface $pulseExceptionInterface, LoggerInterface $logger)
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
        $this->logger->error(sprintf('--- PULSE: RAISON: %s', $throwable->getMessage()));
        $this->logger->error(sprintf('--- PULSE: FILE: %s', $throwable->getFile()));
        $this->logger->error(sprintf('--- PULSE: LINE: %s', $throwable->getLine()));
        $this->logger->error(sprintf('--- PULSE: TRACE: %s', $throwable->getTraceAsString()));
        return $this->pulseExceptionInterface->handleException($throwable);
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof PulseException;
    }

}
