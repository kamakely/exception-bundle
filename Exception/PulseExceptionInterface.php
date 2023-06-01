<?php


namespace Pulse\ExceptionBundle\Exception;


interface PulseExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable);

    /**
     * @param \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable);
}
