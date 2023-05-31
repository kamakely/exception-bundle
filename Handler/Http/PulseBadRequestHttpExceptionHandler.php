<?php


namespace Pulse\ExceptionBundle\Handler\Http;


use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;
use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PulseBadRequestHttpExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    public function setData(\Exception $exception)
    {
        return array_merge(
            array(
                'message' => $exception->getMessage(),
                'http_message' => 'Authentication failed',
                'code' => 400,
            ), $this->getMessageParts($exception)
        );
    }

    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof BadRequestHttpException;
    }

}
