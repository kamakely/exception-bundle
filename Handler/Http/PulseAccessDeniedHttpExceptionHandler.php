<?php


namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PulseAccessDeniedHttpExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @return array
     */
    public function setData(\Throwable $throwable)
    {
        return array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Action non autorisée',
                'code' => 403
            );
    }

    /**
     * @param \Throwable $throwable
     * @return bool
     */
    public function isMatchException(\Throwable $throwable)
    {
        return $throwable instanceof AccessDeniedHttpException;
    }

}
