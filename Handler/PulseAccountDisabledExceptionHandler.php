<?php


namespace Pulse\ExceptionBundle\Handler;


use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;
use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;

class PulseAccountDisabledExceptionHandler extends AbstractPulseException implements PulseExceptionInterface
{
    /**
     * @param \Exception $exception
     * @return array
     */
    public function setData(\Exception $exception)
    {
        return array_merge(
            array(
                'message' => $exception->getMessage(),
                'http_message' => 'User account is disabled.',
                'code' => ConstantSrv::CODE_UNAUTHORIZED,
            ), $this->getMessageParts($exception)
        );
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof DisabledException;
    }

}
