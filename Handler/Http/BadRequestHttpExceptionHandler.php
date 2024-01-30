<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\ExceptionBundle\Exception\AbstractException;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class BadRequestHttpExceptionHandler extends AbstractException implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface $formatResponseInterface)
    {

    }

    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array_merge(
                [
                'message' => $throwable->getMessage(),
                'http_message' => 'Bad Request',
                'code' => Response::HTTP_BAD_REQUEST,
                ],
                $this->getMessageParts($throwable)
            )
        );
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof BadRequestHttpException;
    }

    public function setFormat(FormatResponseInterface $formatResponseInterface): void
    {
        $this->formatResponseInterface = $formatResponseInterface;
    }
}
