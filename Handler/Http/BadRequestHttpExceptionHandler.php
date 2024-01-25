<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\ExceptionBundle\Exception\AbstractException;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestHttpExceptionHandler extends AbstractException implements ExceptionHandlerInterface
{
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array_merge(
                array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Bad Request',
                'code' => Response::HTTP_BAD_REQUEST,
                ),
                $this->getMessageParts($throwable)
            )
        );
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof BadRequestHttpException;
    }

}
