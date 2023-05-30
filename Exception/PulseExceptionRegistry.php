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
     * @param \Exception $exception
     * @return AbstractPosException|PosExceptionInterface
     */
    public function getExceptionHandler(\Exception $exception)
    {
        foreach($this->exceptionHandlers as $exceptionHandler) {
            /** @var AbstractPosException $exceptionHandler **/
            if($exceptionHandler->isMatchException($exception)) {
                return $exceptionHandler;
            }
        }

        return new PulseGenericExceptionHandler();
    }
}
