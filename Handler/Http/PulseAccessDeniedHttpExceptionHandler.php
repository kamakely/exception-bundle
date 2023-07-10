<?php

namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PulseAccessDeniedHttpExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Forbidden',
                'code' => Response::HTTP_FORBIDDEN
            )
        );
    }

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof AccessDeniedHttpException;
    }

}
