<?php

namespace Pulse\ExceptionBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

interface PulseExceptionInterface
{
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response;

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool;
}
