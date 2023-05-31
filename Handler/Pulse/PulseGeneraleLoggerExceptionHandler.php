<?php


namespace Pulse\ExceptionBundle\Handler\Pulse;


use Psr\Log\LoggerInterface;
use Pulse\ExceptionBundle\Exception\PulseException;
use Pulse\ExceptionBundle\Handler\Pulse\PulseGeneralExceptionInterface;

class PulseGeneraleLoggerExceptionHandler implements PulseGeneralExceptionInterface
{
    /**
     * @var PulseGeneralExceptionInterface $generalException
     */
    private $generalException;
    /**
     * @var LoggerInterface $logger
     */
    private $logger;
    public function __construct(PulseGeneralExceptionInterface $generalException, LoggerInterface $logger)
    {
        $this->generalException = $generalException;
        $this->logger = $logger;
    }
    /**
     * @param \Throwable $throwable
     * @return array|string
     */
    public function setData(\Throwable $throwable)
    {
        $this->logger->notice(" --- POSAPP: L'ERREUR SUIVANTE EST LEVÉE PAR POS ---");
        $this->logger->error(sprintf('--- POSAPP: RAISON: %s', $throwable->getMessage()));
        $this->logger->error(sprintf('--- POSAPP: FILE: %s', $throwable->getFile()));
        $this->logger->error(sprintf('--- POSAPP: LINE: %s', $throwable->getLine()));
        $this->logger->error(sprintf('--- POSAPP: TRACE: %s', $throwable->getTraceAsString()));
        return $this->generalException->setData($throwable);
    }

    /**
     * @param \Throwable $exception
     * @return bool
     */
    public function isMatchException(\Throwable $throwable)
    {
        return $throwable instanceof PulseException;
    }

}
