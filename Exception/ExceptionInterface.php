<?php

namespace Tounaf\ExceptionBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

interface ExceptionInterface
{
    /**
     * @param  \Throwable $throwable
     * @return Response
     */
    public function handleException(\Throwable $throwable): Response;

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool;
}
