<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AccessDeniedHttpExceptionHandler implements ExceptionHandlerInterface
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
