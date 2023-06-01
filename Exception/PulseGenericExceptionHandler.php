<?php


namespace Pulse\ExceptionBundle\Exception;

use Pulse\ExceptionBundle\Code;

class PulseGenericExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable)
    {
        $messageExeption = $throwable->getMessage();
        return array(
            'message' => $messageExeption,
            'http_message' => 'Erreur interne',
            'code' => Code::CODE_INTERNAL_ERROR
        );
    }

    /**
     * @param \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable)
    {
        return false;
    }

}
