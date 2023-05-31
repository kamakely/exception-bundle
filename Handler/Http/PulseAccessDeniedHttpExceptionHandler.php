<?php


namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PulseAccessDeniedHttpExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param \Exception $exception
     * @return array
     */
    public function setData(\Exception $exception)
    {
        return array(
                'message' => $exception->getMessage(),
                'http_message' => 'Action non autorisée',
                'code' => 403
            );
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof AccessDeniedHttpException;
    }

}
