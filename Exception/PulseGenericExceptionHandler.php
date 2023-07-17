<?php

namespace Pulse\ExceptionBundle\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PulseGenericExceptionHandler implements PulseExceptionInterface
{
    /**
     * @param  \Throwable $throwable
     * @return array
     */
    public function handleException(\Throwable $throwable): Response
    {
        $messageExeption = $throwable->getMessage();
        return new JsonResponse(
            array(
            'message' => $messageExeption,
            'http_message' => 'Erreur interne',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
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
