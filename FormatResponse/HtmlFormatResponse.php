<?php

namespace Pulse\ExceptionBundle\FormatResponse;

use Symfony\Component\HttpFoundation\Response;

class HtmlFormatResponse implements FormatResponseInterface
{
    public function __construct()
    {
        
    }
    
    /**
     * @var    array $data
     * @return 
     */
    public function set(array $data): Response
    {
        return new Response('ok');
    }

    /**
     * @var    string $format
     * @return bool
     */
    public function format(string $format): bool
    {
        return $format === 'html';
    }
}