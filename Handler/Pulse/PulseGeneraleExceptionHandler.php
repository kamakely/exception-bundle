<?php


namespace Pulse\ExceptionBundle\Handler\Pulse;


use Pulse\ExceptionBundle\Code;
use Pulse\ExceptionBundle\Exception\PulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseGeneraleExceptionHandler implements PulseGeneralExceptionInterface, PulseExceptionInterface
{
    /**
     * @param \Throwable $exception
     * @return array
     */
    public function handleException(\Throwable $throwable): array
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
    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof PulseException;
    }

}
