<?php

namespace Pulse\ExceptionBundle\Handler\Pulse;

use Symfony\Component\HttpFoundation\Response;

interface PulseGeneralExceptionInterface
{
    /**
     * @var \Throwable $throwable
     */
    public function handleException(\Throwable $throwable): Response;
}
