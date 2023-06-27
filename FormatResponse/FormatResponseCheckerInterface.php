<?php

namespace Pulse\ExceptionBundle\FormatResponse;
use Symfony\Component\HttpFoundation\Response;

interface FormatResponseCheckerInterface
{
    
    /**
     * @var    array $data
     * @return bool
     */
    public function format(array $format): bool;

    public function setFormat(FormatResponseInterface $formatResponse): void;
}