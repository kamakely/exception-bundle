<?php

namespace Tounaf\ExceptionBundle\Negociation;

use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FormatNegociator
{
    public function __construct(private RequestStack $request)
    {
        
    }
    /**
     * @var array
     */
    private $map = [];

    public function add(RequestMatcherInterface $requestMatcherInterface, array $options = [])
    {
        $this->map[] = [$requestMatcherInterface, $options];
    }

    public function getBest(): ?string
    {
        $request = $this->getRequest();
        foreach ($this->map as $elements) {
            // Check if the current RequestMatcherInterface matches the current request
            if (!$elements[0]->matches($request)) {
                continue;
            }

            return $elements[1]['format'];
        }

        return null;
    }

    private function getRequest()
    {
        $request = $this->request->getCurrentRequest();
        if(null === $request) {
            throw new \RuntimeException("There is no current request");
        }

        return $request;
    }
}