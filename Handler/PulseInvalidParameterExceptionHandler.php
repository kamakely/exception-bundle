<?php


namespace Pulse\ExceptionBundle\Handler;


use FOS\RestBundle\Exception\InvalidParameterException;
use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;
use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseInvalidParameterExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{

    /**
     * @inheritDoc
     */
    public function setData(\Exception $exception)
    {
        return array_merge(
            array(
                'message' => $exception->getMessage(),
                'http_message' => 'Parametre invalid',
                'code' => ConstantSrv::CODE_UNAUTHORIZED,
            ), $this->getMessageParts($exception)
        );
    }

    /**
     * @inheritDoc
     */
    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof InvalidParameterException;
    }
}
