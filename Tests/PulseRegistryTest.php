<?php

namespace Pulse\ExceptionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Pulse\ExceptionBundle\Exception\PulseExceptionInterface;
use Pulse\ExceptionBundle\Exception\PulseExceptionRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PulseRegistryTest extends KernelTestCase
{
    public function testRightHandler(): void
    {
        $registry = new PulseExceptionRegistry([new Custom()]);
        $exception = new MyException();
        $handler = $registry->getExceptionHandler($exception);
        $this->assertInstanceOf(Custom::class, $handler);
    }

    public function testWrongHandler(): void
    {
        $registry = new PulseExceptionRegistry([new Custom()]);
        $exception = new \Exception();
        $handler = $registry->getExceptionHandler($exception);
        $this->assertNotInstanceOf(Custom::class, $handler);
    }

}


class Custom implements PulseExceptionInterface
{
    /**
     * @param \Exception $exception
     * @return array
     */
    public function handleException(\Throwable $exception): Response
    {
        return new JsonResponse([
            "message" => "custom",
        ]);
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    public function supportsException(\Throwable $exception): bool
    {
        return $exception instanceof MyException;

    }
}

class MyException extends \Exception
{
}
