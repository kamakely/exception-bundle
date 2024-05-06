<?php

namespace Tounaf\ExceptionBundle\Exception;

use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseManager;
use Symfony\Component\HttpFoundation\Request;
use Tounaf\ExceptionBundle\Handler\LogicalExceptionHandler;

class ExceptionRegistry
{
    /**
     * @var PosExceptionInterface[] $exceptionHandlers
     */
    private $exceptionHandlers;

    /**
     * @var FormatResponseManager
     */
    private $formatResponseManager;

    /**
     * @var DecoratorExceptionHandlerInterface[] $decoratorExceptionHandler
     */
    private $decoratorExceptionHandlers = [];

    public function __construct(iterable $exceptionHandlers)
    {
        $this->exceptionHandlers = $exceptionHandlers;
    }

    public function setFormatManager(FormatResponseManager $formatResponseManager): void
    {
        $this->formatResponseManager = $formatResponseManager;
    }

    public function addDecorator(DecoratorExceptionHandlerInterface $decoratorExceptionHandler)
    {
        $this->decoratorExceptionHandlers [] = $decoratorExceptionHandler;
    }



    /**
     * @param  \Throwable $throwable
     * @return AbstractException|ExceptionHandlerInterface
     */
    public function getExceptionHandler(\Throwable $throwable, Request $request)
    {
        $formatResponse = $this->formatResponseManager->getFormatHandler($request->getRequestFormat(null));
        $handler = new GenericExceptionHandler();
        $handler->setFormat($formatResponse);
        try {
            foreach($this->exceptionHandlers as $exceptionHandler) {

                if(!$exceptionHandler instanceof ExceptionHandlerInterface) {
                    throw new TounafException(
                        sprintf(
                            'Handler %s must implement the %s interface',
                            get_class($exceptionHandler),
                            ExceptionHandlerInterface::class
                        )
                    );
                }

                if($exceptionHandler->supportsException($throwable)) {

                    if ($exceptionHandler instanceof FormatResponseCheckerInterface) {
                        $exceptionHandler->setFormat($formatResponse);
                    }

                    $handler = $exceptionHandler;
                    break;
                }
            }

        } catch(\Throwable) {

            $handler = new LogicalExceptionHandler($formatResponse);

        }
        
        return  $this->decoratesHandler($handler);
    }

    private function decoratesHandler($handler)
    {
        foreach($this->decoratorExceptionHandlers as $decoratorHandler) {
            /**
             * @var DecoratorExceptionHandlerInterface $decoratorHandler
             */
            $decoratorHandler->decoratesHandler($handler);
            $handler = $decoratorHandler;
        }

        return $handler;
    }
}
