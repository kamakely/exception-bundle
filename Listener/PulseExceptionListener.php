<?php

namespace Pulse\ExceptionBundle\Listener;

use Pulse\ExceptionBundle\Exception\PulseExceptionRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class PulseExceptionListener
{
    public function __construct(private PulseExceptionRegistry $pulseExceptionRegistry, private string $debug)
    {

    }
    public function __invoke(ExceptionEvent $exceptionEvent)
    {
        if($this->debug) {
            return;
        }
        $exception = $exceptionEvent->getThrowable();
        $handler = $this->pulseExceptionRegistry->getExceptionHandler($exception);
        $response = $handler->handleException($exception);
        $exceptionEvent->setResponse($response);
    }
}
