<?php

namespace Tounaf\ExceptionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tounaf\ExceptionBundle\Exception\ExceptionHandlerInterface;
use Tounaf\ExceptionBundle\Exception\ExceptionRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseManager;

class RegistryTest extends KernelTestCase
{
    private $registry;
    private $request;

    public function setUp(): void
    {
        $this->registry = new ExceptionRegistry([new CustomHandler()]);
        $this->registry->setFormatManager(new FormatResponseManager());
        $this->request = Request::createFromGlobals();
    }
    
    public function testRightHandler(): void
    {
        $exception = new MyException();
        $handler = $this->registry->getExceptionHandler($exception, $this->request);
        $this->assertInstanceOf(CustomHandler::class, $handler);
    }

    public function testWrongHandler(): void
    {
        $exception = new \Exception();
        $handler = $this->registry->getExceptionHandler($exception, $this->request);
        $this->assertNotInstanceOf(CustomHandler::class, $handler);
    }

}


class CustomHandler implements ExceptionHandlerInterface
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
