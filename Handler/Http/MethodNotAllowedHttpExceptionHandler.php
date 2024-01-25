<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\Bundle\CommunBundle\Utils\ConstantSrv;
use Tounaf\ExceptionBundle\Exception\AbstractException;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MethodNotAllowedHttpExceptionHandler extends AbstractException implements ExceptionHandlerInterface
{
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array_merge(
                array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Method Not Allowed',
                'code' => Response::HTTP_METHOD_NOT_ALLOWED,
                ),
                $this->getMessageParts($throwable)
            )
        );
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof MethodNotAllowedHttpException;
    }

}
