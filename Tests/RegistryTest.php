<?php

namespace Tounaf\ExceptionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Tounaf\ExceptionBundle\Exception\ExceptionRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistryTest extends KernelTestCase
{
    public function testRightHandler(): void
    {
        $request = Request::createFromGlobals();
        $registry = new ExceptionRegistry([new Custom()]);
        $exception = new MyException();
        $handler = $registry->getExceptionHandler($exception, $request);
        $this->assertInstanceOf(Custom::class, $handler);
    }

    public function testWrongHandler(): void
    {
        $request = Request::createFromGlobals();
        $registry = new ExceptionRegistry([new Custom()]);
        $exception = new \Exception();
        $handler = $registry->getExceptionHandler($exception, $request);
        $this->assertNotInstanceOf(Custom::class, $handler);
    }

}


class Custom implements ExceptionHandlerInterface
{
    /**
     * @param  \Exception $exception
     * @return array
     */
    public function handleException(\Throwable $exception): Response
    {
        return new JsonResponse(
            [
            "message" => "custom",
            ]
        );
    }

    /**
     * @param  \Exception $exception
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
