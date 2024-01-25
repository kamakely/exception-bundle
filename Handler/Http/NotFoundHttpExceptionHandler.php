<?php

namespace Tounaf\ExceptionBundle\Handler\Http;

use Tounaf\ExceptionBundle\Exception\AbstractException;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundHttpExceptionHandler extends AbstractException implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface|null $formatResponseInterface)
    {
        
    }
    public function handleException(\Throwable $throwable): Response
    {
        return $this->formatResponseInterface->render(
            array_merge(
                array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Not found',
                'code' => Response::HTTP_NOT_FOUND,
                ),
                $this->getMessageParts($throwable)
            )
        );
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof NotFoundHttpException;
    }

    /**
     * @var    string $format
     * @return bool
     */
    public function format(array $format): bool
    {
        return $format === 'json';
    }

    public function setFormat(FormatResponseInterface $formatResponse): void
    {
        $this->formatResponseInterface = $formatResponse;
    }

}
