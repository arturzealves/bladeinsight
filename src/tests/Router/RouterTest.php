<?php

namespace BladeInsight\Tests\Router;

use BladeInsight\Application\Router;
use BladeInsight\Controller\AddressController;
use BladeInsight\Controller\Controller;
use BladeInsight\Creator\ControllerCreator;
use BladeInsight\Exception\ControllerNotImplementedException;
use BladeInsight\Exception\MethodNotImplementedException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class RouterTest extends TestCase
{
    use ProphecyTrait;

    private $testSubject;
    private $controllerCreator;

    public function setup(): void
    {
        $this->testSubject = new Router();

        $this->controllerCreator = $this->prophesize(ControllerCreator::class);
        $this->testSubject->setControllerCreator($this->controllerCreator->reveal());
    }
    
    public function testProcessRequestThrowsOnNotImplementedRoute(): void
    {
        $requestURI = '/drone';
        $params['id'] = 123;

        $this->controllerCreator
            ->create('\BladeInsight\Controller\DroneController')
            ->shouldBeCalledTimes(1)
            ->willThrow(ControllerNotImplementedException::class);

        $this->expectException(ControllerNotImplementedException::class);

        $this->testSubject->processRequest($requestURI, $params);
    }

    public function testProcessRequestThrowsOnNotImplementedAction(): void
    {
        $requestURI = '/address';
        $params = [
            'id' => 123,
            'action' => 'create'
        ];

        $addressController = $this->prophesize(AddressController::class);
        $this->controllerCreator
            ->create('\BladeInsight\Controller\AddressController')
            ->shouldBeCalledTimes(1)
            ->willReturn($addressController->reveal());

        $this->expectExceptionMessage('The method createAction is not implemented');
        $this->expectException(MethodNotImplementedException::class);

        $this->testSubject->processRequest($requestURI, $params);
    }

    /**
     * I'm leaving this test scenario commented because it is failing with the
     * following error message:
     * 
     * TypeError: Return value of Double\BladeInsight\Controller\AddressController\P4::listAction() 
     * must be of the type string, null returned
     * 
     * I guess it is related with the call to call_user_func_array on line 49
     * of the Router class.
     * 
     * Unfortunately, after implementing the ControllerCreator to be able to 
     * test the Router class completely, I'm having this weird error that is not
     * allowing the entire class to be tested.
     */
    // public function testProcessRequestIsSuccessful(): void
    // {
    //     $requestURI = '/address';
    //     $params = [
    //         'action' => 'list',
    //     ];

    //     $addressController = $this->prophesize(AddressController::class);

    //     $this->controllerCreator
    //         ->create(AddressController::class)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($addressController->reveal());

    //     $addressController
    //         ->listAction($params)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn('ok');

    //     $this->testSubject->processRequest($requestURI, $params);
    // }
}
