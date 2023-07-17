<?php

namespace Pulse\ExceptionBundle\FormatResponse;
use Symfony\Component\HttpFoundation\Response;

interface FormatResponseInterface
{
    
    /**
     * @var    array $data
     * @return 
     */
    public function render(array $data): Response;

    /**
     * @var    string $format
     * @return bool
     */
    public function supportsFormat(string $format): bool;

}