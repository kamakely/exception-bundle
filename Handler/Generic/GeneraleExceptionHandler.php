<?php

namespace Tounaf\ExceptionBundle\Handler\Generic;

use Tounaf\ExceptionBundle\Exception\Exception;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\Exception\TounafException;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class GeneraleExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface $formatResponseInterface)
    {

    }
    /**
     * @param  \Throwable $exception
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            [
            'message' => $throwable->getMessage(),
            'http_message' => 'Internal error',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]
        );
    }

    /**
     * @param  \Exception $exception
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof TounafException;
    }

    public function setFormat(FormatResponseInterface $formatResponseInterface): void
    {
        $this->formatResponseInterface = $formatResponseInterface;
    }

}
