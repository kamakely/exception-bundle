<?php


namespace Pulse\ExceptionBundle\Handler;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Pulse\ExceptionBundle\Code;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;

class PulseUniqueConstraintViolationExceptionHandler implements PulseExceptionInterface
{
    public function setData(\Exception $exception)
    {
        $messageExeption = $exception->getMessage();
        if (preg_match('#Duplicate entry \'(.*)\'#Uis', $messageExeption, $val)
            || preg_match('#Duplicata du champ \'(.*)\'#Uis', $messageExeption, $val)
        ) {
            $messageExeption = $val[1];
        }
        return array(
            'message' => "L'élément  " . (string)$messageExeption . " existe déjà !",
            'http_message' => 'Duplicate entry',
            'code' => Code::CODE_INTERNAL_ERROR,
        );
    }

    public function isMatchException(\Exception $exception)
    {
        return $exception instanceof UniqueConstraintViolationException;
    }

}
