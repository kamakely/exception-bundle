<?php

namespace Pulse\ExceptionBundle\FormatResponse;
use Symfony\Component\HttpFoundation\Response;

interface FormatResponseInterface
{
    
    /**
     * @var array $data
     * @return 
     */
    public function set(array $data): Response;

    /**
     * @var string $format
     * @return bool
     */
    public function format(string $format): bool;

}