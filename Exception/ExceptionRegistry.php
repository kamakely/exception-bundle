<?php

namespace Tounaf\ExceptionBundle\Exception;

use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseManager;
use Tounaf\ExceptionBundle\Handler\LogicExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

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

    public function __construct(iterable $exceptionHandlers)
    {
        $this->exceptionHandlers = $exceptionHandlers;
    }

    public function setFormatManager(FormatResponseManager $formatResponseManager): void
    {
        $this->formatResponseManager = $formatResponseManager;
    }

    /**
     * @param  \Throwable $throwable
     * @return AbstractException|ExceptionHandlerInterface
     */
    public function getExceptionHandler(\Throwable $throwable, Request $request)
    {
        $handler = new GenericExceptionHandler();
        
        try {
            foreach($this->exceptionHandlers as $exceptionHandler) {

                if(!$exceptionHandler instanceof ExceptionHandlerInterface) {
                    throw new TounafException(sprintf('Handler %s must implement the %s interface', get_class($exceptionHandler), ExceptionHandlerInterface::class));
                }

                if($exceptionHandler->supportsException($throwable)) {

                    if ($exceptionHandler instanceof FormatResponseCheckerInterface) {
                        $formatResponse = $this->formatResponseManager->getFormatHandler($request->getRequestFormat(null));
                        $exceptionHandler->setFormat($formatResponse);
                    }
                    
                    return $exceptionHandler;
                }
            }

        } catch(\Exception $exception) {

            return new LogicExceptionHandler($exception->getMessage());

        }

        return $handler;
    }
}
