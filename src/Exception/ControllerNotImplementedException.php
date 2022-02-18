<?php

namespace BladeInsight\Exception;

class ControllerNotImplementedException extends \Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('The controller %s is not implemented', $message), $code, $previous);
    }
}
