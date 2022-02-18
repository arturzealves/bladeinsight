<?php

namespace BladeInsight\Application;

use BladeInsight\Controller\Controller;
use BladeInsight\Creator\ControllerCreator;
use BladeInsight\Exception\ControllerNotImplementedException;
use BladeInsight\Exception\MethodNotImplementedException;

class Router
{
    protected $controllerCreator;

    public function __construct()
    {
        $this->controllerCreator = new ControllerCreator();
    }

    public function processRequest(string $requestURI, array $params): void
    {
        // Gets the URL path from the requested URI
        $requestedRoute = parse_url($requestURI, PHP_URL_PATH);
        
        // Converts the route path to an array, using '/' as a separator
        $splittedRoute = explode('/', $requestedRoute);
        
        // Ignores the first element in the array, which is an empty string
        array_shift($splittedRoute);
        
        // Transform the obtained route name to the controller class name
        $controllerName = sprintf(
            "\%s\%sController", 
            'BladeInsight\Controller', 
            ucfirst(current($splittedRoute))
        );
        
        // Instanciate the requested Controller and determine the method to call
        $controller = $this->controllerCreator->create($controllerName);
        $method = isset($params['action']) ? $params['action'] : 'execute';
        $method .= 'Action';
        
        // Throws an exception if the requested method isn't implemented yet
        if (!method_exists($controller, $method)) {
            throw new MethodNotImplementedException($method);
        }

        // Call the given Controller's method and print its response
        echo call_user_func_array([$controller, $method], $params);
    }

    public function setControllerCreator(ControllerCreator $creator): self
    {
        $this->controllerCreator = $creator;

        return $this;
    }
}
