<?php

namespace Tounaf\ExceptionBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tounaf\Exception\Exception\ExceptionHandlerInterface;
use Tounaf\Exception\Exception\ExceptionRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\Exception\Exception\GenericExceptionHandler;
use Tounaf\Exception\FormatResponse\FormatResponseManager;
use Tounaf\Exception\FormatResponse\HtmlFormatResponse;
use Tounaf\Exception\FormatResponse\JsonFormatResponse;
use Tounaf\Exception\Handler\LogicalExceptionHandler;

class RegistryTest extends KernelTestCase
{
    private $registry;
    private $request;

    public function setUp(): void
    {
        $this->registry = $this->configureExceptionRegistry();
        $this->request = Request::createFromGlobals();
        $this->request->setRequestFormat('json');
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

    public function testBadImplementationHandler(): void
    {
        $handler = $this->createBadHandler();
        $this->assertNotInstanceOf(BadHandler::class, $handler);
    }

    public function testBadCatchedByLogicalHandler(): void
    {
        $handler = $this->createBadHandler();
        $this->assertInstanceOf(LogicalExceptionHandler::class, $handler);
    }

    public function testNoConfiguredHandler(): void
    {
        $registry = new ExceptionRegistry([]);
        $registry->setFormatManager(new FormatResponseManager());
        $handler = $registry->getExceptionHandler(new \Exception(), $this->request);
        $this->assertInstanceOf(GenericExceptionHandler::class, $handler);
    }

    public function testResponse(): void
    {
        $registry = new ExceptionRegistry([]);
        $registry->setFormatManager(new FormatResponseManager());
        $handler = $registry->getExceptionHandler(new \Exception(), $this->request);
        $response = $handler->handleException(new \Exception());
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testJsonResponse(): void
    {

        /**
         * @var Request $request
         */
        $request = $this->request;
        $request->setRequestFormat('json');
        $handler = $this->registry->getExceptionHandler(new \Exception(), $this->request);
        $response = $handler->handleException(new \Exception());
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    private function configureExceptionRegistry()
    {
        $formatManager = $this->configureFormatManager();
        $registry = new ExceptionRegistry([new CustomHandler()]);
        $registry->setFormatManager($formatManager);
        return $registry;
    }

    private function configureFormatManager()
    {
        $formatManager = new FormatResponseManager();
        $formatManager->addFormatResponse(new HtmlFormatResponse());
        $formatManager->addFormatResponse(new JsonFormatResponse());
        return $formatManager;
    }

    private function createBadHandler()
    {
        $registry = new ExceptionRegistry([new BadHandler()]);
        $registry->setFormatManager(new FormatResponseManager());
        return $registry->getExceptionHandler(new \Exception(), $this->request);
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
     */
    public function supportsException(\Throwable $exception): bool
    {
        return $exception instanceof MyException;

    }
}

class BadHandler
{
    /**
     * @param  \Exception $exception
     * @return array
     */
    public function handleException(\Throwable $exception): Response
    {
        return new JsonResponse(
            [
            "message" => "bad handler",
            ]
        );
    }

    /**
     * @param  \Exception $exception
     */
    public function supportsException(\Throwable $exception): bool
    {
        return $exception instanceof \Exception;

    }
}

class MyException extends \Exception
{
}
