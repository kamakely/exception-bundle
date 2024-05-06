<?php

namespace Tounaf\ExceptionBundle\Listener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Tounaf\Exception\Negociation\FormatNegociator;

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
