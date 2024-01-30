<?php

namespace Tounaf\ExceptionBundle\FormatResponse;

use Symfony\Component\HttpFoundation\Request;

final class FormatResponseManager
{
    private $formatHandlers = [];
    /**
     * @var Request
     */
    private $request;
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    public function addFormatResponse(FormatResponseInterface $formatResponseInterface)
    {
        $this->formatHandlers[] = $formatResponseInterface;
    }

    public function getFormatHandler(?string $format): FormatResponseInterface
    {
        foreach($this->formatHandlers as $formatHandler) {
            if($formatHandler->supportsFormat($format)) {
                return $formatHandler;
            }
        }

        return new JsonFormatResponse();
    }

    public function getFormatHandlers()
    {
        return $this->formatHandlers;
    }
}
