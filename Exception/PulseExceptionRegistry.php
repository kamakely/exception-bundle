<?php

namespace Pulse\ExceptionBundle\Exception;

use Pulse\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Pulse\ExceptionBundle\FormatResponse\HtmlFormatResponse;
use Pulse\ExceptionBundle\FormatResponse\JsonFormatResponse;
use Pulse\ExceptionBundle\Handler\PulseLogicExceptionHandler;

class PulseExceptionRegistry
{
    /**
     * @var PosExceptionInterface[] $exceptionHandlers
     */
    private $exceptionHandlers;
    public function __construct(iterable $exceptionHandlers)
    {
        $this->exceptionHandlers = $exceptionHandlers;
    }

    /**
     * @param  \Throwable $throwable
     * @return AbstractPulseException|PulseExceptionInterface
     */
    public function getExceptionHandler(\Throwable $throwable)
    {
        $handler = new PulseGenericExceptionHandler();
        try {
            foreach($this->exceptionHandlers as $exceptionHandler) {
                if(!$exceptionHandler instanceof PulseExceptionInterface) {
                    throw new PulseException(sprintf('Handler %s must implement the %s interface', get_class($exceptionHandler), PulseExceptionInterface::class));
                }

                if($exceptionHandler->supportsException($throwable)) {
                    if ($exceptionHandler instanceof FormatResponseCheckerInterface) {
                        $exceptionHandler->setFormat(new JsonFormatResponse());
                    }
                    $handler = $exceptionHandler;
                }
            }
        } catch(\Exception $exception) {
            return new PulseLogicExceptionHandler($exception->getMessage());
        }

        return $handler;
    }
}
