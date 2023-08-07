<?php

namespace Tounaf\ExceptionBundle\Handler\Generic;

use Symfony\Component\HttpFoundation\Response;

interface PulseGeneralExceptionInterface
{
    /**
     * @var \Throwable $throwable
     */
    public function handleException(\Throwable $throwable): Response;
}
