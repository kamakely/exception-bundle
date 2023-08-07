<?php

namespace Tounaf\ExceptionBundle\Listener;

use Tounaf\ExceptionBundle\Negociation\FormatNegociator;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class FormatRequestListener
{
    public function __construct(private FormatNegociator $formatNegociator)
    {

    }
    public function __invoke(RequestEvent $requestEvent)
    {
        $requestEvent->getRequest()->setRequestFormat($this->formatNegociator->getBest());
    }
}
