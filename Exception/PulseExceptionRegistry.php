<?php

namespace Pulse\ExceptionBundle\Exception;

use Pulse\ExceptionBundle\Handler\PulseLogicExceptionHandler;
use Symfony\Component\HttpKernel\Attribute\Cache;

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
     * @param \Throwable $throwable
     * @return AbstractPulseException|PulseExceptionInterface
     */
    public function getExceptionHandler(\Throwable $throwable)
    {
        try {
            foreach($this->exceptionHandlers as $exceptionHandler) {
                if(!$exceptionHandler instanceof PulseExceptionInterface) {
                    throw new PulseException(sprintf('Handler %s must implement the %s interface', get_class($exceptionHandler), PulseExceptionInterface::class));
                }
                /** @var AbstractPulseException|PulseExceptionInterface $exceptionHandler **/
                if($exceptionHandler->supportsException($throwable)) {
                    return $exceptionHandler;
                }
            }
        } catch(\Exception $exception) {
            return new PulseLogicExceptionHandler($exception->getMessage());
        }


        return new PulseGenericExceptionHandler();
    }
}
