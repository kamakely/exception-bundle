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
     * @param \Exception $exception
     * @return array|string
     */
    public function setData(\Exception $exception)
    {
        $this->logger->notice(" --- POSAPP: L'ERREUR SUIVANTE EST LEVÉE PAR POS ---");
        $this->logger->error(sprintf('--- POSAPP: RAISON: %s', $exception->getMessage()));
        $this->logger->error(sprintf('--- POSAPP: FILE: %s', $exception->getFile()));
        $this->logger->error(sprintf('--- POSAPP: LINE: %s', $exception->getLine()));
        $this->logger->error(sprintf('--- POSAPP: TRACE: %s', $exception->getTraceAsString()));
        return $this->generalException->setData($exception);
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof PulseException;
    }

}
