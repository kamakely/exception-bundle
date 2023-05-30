<?php


namespace Pulse\ExceptionBundle\Exception;


interface PulseExceptionInterface
{
    /**
     * @param \Exception $exception
     * @return array
     */
    public function setData(\Exception $exception);

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function isMatchException(\Exception $exception);
}
