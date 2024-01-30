<?php

namespace Tounaf\ExceptionBundle\Handler;

use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class LogicExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface $formatResponseInterface)
    {

    }
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        return $this->formatResponseInterface->render(
            [
                'message' => $throwable->getMessage(),
                'http_message' => 'Logical Exception'
            ]
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

    public function setFormat(FormatResponseInterface $formatResponseInterface): void
    {
        $this->formatResponseInterface = $formatResponseInterface;
    }
}
