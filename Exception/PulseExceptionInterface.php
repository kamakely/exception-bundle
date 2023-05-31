<?php


namespace Pulse\ExceptionBundle\Exception;


interface PulseExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @return array
     */
    public function setData(\Throwable $throwable);

    /**
     * @param \Throwable $throwable
     * @return bool
     */
    public function isMatchException(\Throwable $throwable);
}
