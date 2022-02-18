<?php

namespace BladeInsight\Tests\Creator;

use BladeInsight\Controller\Controller;
use BladeInsight\Creator\ControllerCreator;
use BladeInsight\Exception\ControllerNotImplementedException;
use PHPUnit\Framework\TestCase;

class ControllerCreatorTest extends TestCase
{
    private $testSubject;
    private $controller;

    public function setup(): void
    {
        $this->testSubject = new ControllerCreator();
    }
    
    public function testCreateReturns(): void
    {
        $this->assertInstanceOf(
            Controller::class,
            $this->testSubject->create(Controller::class)
        );
    }

    public function testCreateThrows(): void
    {
        $this->expectExceptionMessage(
            'The controller BladeInsight\Controller\ControllerCreatorTestBreaker is not implemented'
        );
        $this->expectException(ControllerNotImplementedException::class);

        $this->testSubject->create(Controller::class . 'CreatorTestBreaker');
    }
}
