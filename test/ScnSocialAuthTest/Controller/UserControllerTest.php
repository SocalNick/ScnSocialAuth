<?php
/**
 * @link      https://github.com/SocalNick/ScnSocialAuth for the canonical source repository
 * @copyright Copyright (c) 2012 Nicholas Calugar (http://socalnick.github.com)
 */

namespace ScnSocialAuthTest\Controller;

use ScnSocialAuth\Controller\UserController;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Request;

/**
 * Unit tests for PhlySimplePage\PageController
 */
class PageControllerTest extends TestCase
{
    public function setUp()
    {
        $this->event      = new MvcEvent();
        $this->controller = new UserController();
        $this->controller->setEvent($this->event);
    }

    public function testIsEventManagerAware()
    {
        $this->assertInstanceOf('Zend\EventManager\EventManagerAwareInterface', $this->controller);
    }

    public function testIsDispatchable()
    {
        $this->assertInstanceOf('Zend\Stdlib\DispatchableInterface', $this->controller);
    }

    public function testIsEventInjectable()
    {
        $this->assertInstanceOf('Zend\Mvc\InjectApplicationEventInterface', $this->controller);
    }

    public function testRaisesExceptionOnDispatchIfEventDoesNotContainRouteMatch()
    {
        $request = new Request();
        $this->setExpectedException('Zend\Mvc\Exception\DomainException', 'Missing route matches');
        $this->controller->dispatch($request);
    }
}
