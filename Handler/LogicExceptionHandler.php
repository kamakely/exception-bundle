<?php

namespace Tounaf\ExceptionBundle\Handler;

use Tounaf\ExceptionBundle\Exception\ExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LogicExceptionHandler implements ExceptionInterface
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
                'http_message' => 'Logical Exception',
                'code' => 400
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
