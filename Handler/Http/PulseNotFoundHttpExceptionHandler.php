<?php

namespace Pulse\ExceptionBundle\Handler\Http;

use Pulse\ExceptionBundle\Exception\AbstractPulseException;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Pulse\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Pulse\ExceptionBundle\FormatResponse\FormatResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PulseNotFoundHttpExceptionHandler extends AbstractPulseException implements PulseExceptionInterface, FormatResponseCheckerInterface
{
    public function __construct(private FormatResponseInterface|null $formatResponseInterface)
    {
        
    }
    public function handleException(\Throwable $throwable): Response
    {
        return $this->formatResponseInterface->set(
            array_merge(
                array(
                'message' => $throwable->getMessage(),
                'http_message' => 'Not found',
                'code' => 404,
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
