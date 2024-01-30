<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class AccessDeniedHttpExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface $formatResponseInterface)
    {

    }
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        return $this->formatResponseInterface->render(
            [
                'message' => $throwable->getMessage(),
                'http_message' => 'Forbidden',
                'code' => Response::HTTP_FORBIDDEN
            ]
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

    public function setFormat(FormatResponseInterface $formatResponseInterface): void
    {
        $this->formatResponseInterface = $formatResponseInterface;
    }

}
