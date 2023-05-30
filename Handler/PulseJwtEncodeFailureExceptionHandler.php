<?php


namespace Pulse\ExceptionBundle\Handler;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Pulse\ExceptionBundle\Code;
use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseJwtEncodeFailureExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    public function setData(\Exception $exception)
    {
        return array_merge(
            array(
                'message' => $exception->getMessage(),
                'http_message' => 'Authentication failed',
                'code' => Code::CODE_INTERNAL_ERROR,
            ), $this->getMessageParts($exception)
        );
    }

    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof JWTEncodeFailureException;
    }

}
