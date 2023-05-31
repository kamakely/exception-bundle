<?php

namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PulseNotFoundHttpExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    public function setData(\Throwable $throwable)
    {
        return array_merge(
            array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Not found',
                'code' => 404,
            ), $this->getMessageParts($throwable)
        );
    }

    public function isMatchException(\Throwable $throwable)
    {
        return $throwable instanceof NotFoundHttpException;
    }

}
