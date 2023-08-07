<?php

namespace Tounaf\ExceptionBundle\FormatResponse;

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
    public function render(array $data): Response
    {
        return new Response('error');
    }

    /**
     * @var    string $format
     * @return bool
     */
    public function supportsFormat(string $format): bool
    {
        return $format === 'html';
    }

}