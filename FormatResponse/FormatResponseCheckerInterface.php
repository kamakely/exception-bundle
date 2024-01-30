<?php

namespace Tounaf\ExceptionBundle\FormatResponse;

interface FormatResponseCheckerInterface
{
    /**
     * @var $formatResponse FormatResponseInterface
     */
    public function setFormat(FormatResponseInterface $formatResponse): void;
}
