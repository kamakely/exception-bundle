<?php

namespace Tounaf\ExceptionBundle\FormatResponse;

interface FormatResponseCheckerInterface
{
    
    /**
     * @var    array $data
     * @return bool
     */
    public function format(array $format): bool;

    public function setFormat(FormatResponseInterface $formatResponse): void;
}