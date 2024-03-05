<?php

namespace Tounaf\ExceptionBundle\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;

class GenericExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    /**
     * @var formatResponseInterface FormatResponseInterface
     */
    private $formatResponseInterface;

    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        $messageExeption = $throwable->getMessage();
        return $this->formatResponseInterface->render(
            [
            'message' => $messageExeption,
            'http_message' => 'Erreur interne',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
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
