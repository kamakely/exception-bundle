<?php


namespace Pulse\ExceptionBundle\Exception;


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
        foreach($this->exceptionHandlers as $exceptionHandler) {
            /** @var AbstractPulseException|PulseExceptionInterface $exceptionHandler **/
            if($exceptionHandler->supportsException($throwable)) {
                return $exceptionHandler;
            }
        }

        return new PulseGenericExceptionHandler();
    }
}
