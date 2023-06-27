<?php

namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;
use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class PulseMethodNotAllowedHttpExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array_merge(
                array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Method Not Allowed',
                'code' => 402,
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
