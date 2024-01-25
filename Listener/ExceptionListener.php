<?php

namespace Tounaf\ExceptionBundle\Listener;

use Tounaf\ExceptionBundle\Exception\ExceptionRegistry;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseManager;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __construct(private ExceptionRegistry $exceptionRegistry, private FormatResponseManager $formatResponseManager, private string $debug)
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
