<?php


namespace Pulse\ExceptionBundle\Handler\Pulse;


use Pulse\ExceptionBundle\Code;
use Pulse\ExceptionBundle\Exception\PulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface as ExceptionPulseExceptionInterface;

class PulseGeneraleExceptionHandler implements ExceptionPulseExceptionInterface, PulseGeneralExceptionInterface
{
    /**
     * @param \Throwable $exception
     * @return array|string
     */
    public function setData(\Throwable $throwable)
    {
        return array(
            'message' => $throwable->getMessage(),
            'http_message' => 'Erreur interne',
            'code' => Code::CODE_INTERNAL_ERROR
        );
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Throwable $throwable)
    {
        return $throwable instanceof PulseException;
    }

}
