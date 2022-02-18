<?php

namespace BladeInsight\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Could not find the requested file: %s', $message), $code, $previous);
    }
}
