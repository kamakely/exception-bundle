<?php

namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PulseBadRequestHttpExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(array_merge(
            array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Authentication failed',
                'code' => 400,
            ),
            $this->getMessageParts($throwable)
        ));
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof BadRequestHttpException;
    }

}
