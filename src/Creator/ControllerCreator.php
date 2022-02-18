<?php

namespace BladeInsight\Creator;

use BladeInsight\Controller\Controller;
use BladeInsight\Exception\ControllerNotImplementedException;

class ControllerCreator
{
    public function create($className)
    {
        // Throws an exception if the requested controller isn't implemented yet
        if (!class_exists($className)) {
            throw new ControllerNotImplementedException($className);
        }

        return new $className();
    }
}
