<?php


namespace Pulse\ExceptionBundle\Handler\Pulse;

interface PulseGeneralExceptionInterface
{
    /**
     * @var \Throwable $throwable
     */
    public function handleException(\Throwable $throwable): array;
}
