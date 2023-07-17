<?php

namespace Pulse\ExceptionBundle\Listener;

use Pulse\ExceptionBundle\Exception\PulseExceptionRegistry;
use Pulse\ExceptionBundle\FormatResponse\FormatResponseManager;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class PulseExceptionListener
{
    public function __construct(private PulseExceptionRegistry $pulseExceptionRegistry, private FormatResponseManager $formatResponseManager, private string $debug)
    {

    }
    public function __invoke(ExceptionEvent $exceptionEvent)
    {
        if($this->debug) {
            return;
        }
        
        $request = $exceptionEvent->getRequest();
        $exception = $exceptionEvent->getThrowable();
        $this->pulseExceptionRegistry->setFormatManager($this->formatResponseManager);
        $handler = $this->pulseExceptionRegistry->getExceptionHandler($exception, $request);
        $response = $handler->handleException($exception);
        $exceptionEvent->setResponse($response);
    }
}
