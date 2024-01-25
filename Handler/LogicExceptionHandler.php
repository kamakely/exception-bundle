<?php

namespace Tounaf\ExceptionBundle\Handler;

use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LogicExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(private string $message)
    {

    }
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        return new JsonResponse(
            array(
                'message' => $this->message,
                'http_message' => 'Logical Exception'
            )
        );
    }

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool
    {
        return false;
    }

}
