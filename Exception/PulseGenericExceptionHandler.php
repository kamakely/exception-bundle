<?php


namespace Pulse\ExceptionBundle\Exception;


use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;

class PulseGenericExceptionHandler implements PulseExceptionInterface
{
    public function setData(\Exception $exception)
    {
        $messageExeption = $exception->getMessage();
        return array(
            'message' => $messageExeption,
            'http_message' => 'Erreur interne',
            'code' => ConstantSrv::CODE_INTERNAL_ERROR
        );
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception)
    {
        return false;
    }

}
