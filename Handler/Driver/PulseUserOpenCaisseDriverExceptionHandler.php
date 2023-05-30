<?php


namespace Pulse\ExceptionBundle\Handler\Driver;


use Doctrine\DBAL\Exception\DriverException;
use Pulse\Bundle\CommunBundle\Utils\ConstantSrv;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseUserOpenCaisseDriverExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param \Exception $exception
     * @return array
     */
    public function setData(\Exception $exception)
    {

        return array(
            'message'      => 'Cet utilisateur a déjà une caisse ouverte',
            'http_message' => 'Action non aboutie',
            'code'         => ConstantSrv::CODE_INTERNAL_ERROR
        );
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof DriverException && $exception->getSQLState() == ConstantSrv::SQL_STATE_DEJA_CAISSE_OUVERTE_UTILISATEUR;
    }

}
