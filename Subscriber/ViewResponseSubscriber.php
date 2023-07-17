<?php

namespace Pulse\ExceptionBundle\Subscriber;

use Pulse\ExceptionBundle\FormatResponse\FormatResponseManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ViewResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private FormatResponseManager $formatResponseManager)
    {
        
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 300]
        ];
    }

    public function onKernelResponse(ResponseEvent $responseEvent)
    {
        $response = $responseEvent->getResponse();
        $statusCode = $response->getStatusCode();
        if($statusCode >= 300) {
            $response = $this->formatResponseManager->getFormatHandler($format);
        }
    }
}
