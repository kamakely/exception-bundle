<?php

namespace Pulse\ExceptionBundle\Exception;

use Pulse\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Pulse\ExceptionBundle\FormatResponse\FormatResponseManager;
use Pulse\ExceptionBundle\Handler\PulseLogicExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

class PulseExceptionRegistry
{
    /**
     * @var PosExceptionInterface[] $exceptionHandlers
     */
    private $exceptionHandlers;

    /**
     * @var FormatResponseManager 
     */
    private $formatResponseManager;

    public function __construct(iterable $exceptionHandlers)
    {
        $this->exceptionHandlers = $exceptionHandlers;
    }

    public function setFormatManager(FormatResponseManager $formatResponseManager): void
    {
        $this->formatResponseManager = $formatResponseManager;
    }

    /**
     * @param  \Throwable $throwable
     * @return AbstractPulseException|PulseExceptionInterface
     */
    public function getExceptionHandler(\Throwable $throwable, Request $request)
    {
        $handler = new PulseGenericExceptionHandler();
        try {
            foreach($this->exceptionHandlers as $exceptionHandler) {
                if(!$exceptionHandler instanceof PulseExceptionInterface) {
                    throw new PulseException(sprintf('Handler %s must implement the %s interface', get_class($exceptionHandler), PulseExceptionInterface::class));
                }

                if($exceptionHandler->supportsException($throwable)) {
                    if ($exceptionHandler instanceof FormatResponseCheckerInterface) {
                        $formatResponse = $this->formatResponseManager->getFormatHandler($request->getRequestFormat(null));
                        $exceptionHandler->setFormat($formatResponse);
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
