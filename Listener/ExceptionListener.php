<?php

namespace Tounaf\ExceptionBundle\Listener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Tounaf\Exception\Exception\ExceptionRegistry;
use Tounaf\Exception\FormatResponse\FormatResponseManager;

class ExceptionListener
{
    public function __construct(private ExceptionRegistry $exceptionRegistry, private FormatResponseManager $formatResponseManager, private bool $debug)
    {

    }
    public function __invoke(ExceptionEvent $exceptionEvent)
    {
        if($this->debug) {
            return;
        }

        $request = $exceptionEvent->getRequest();
        $exception = $exceptionEvent->getThrowable();

        $this->exceptionRegistry->setFormatManager($this->formatResponseManager);
        $handler = $this->exceptionRegistry->getExceptionHandler($exception, $request);
        $response = $handler->handleException($exception);

        $exceptionEvent->setResponse($response);
    }
}
