<?php
/**
 * @link      https://github.com/SocalNick/ScnSocialAuth for the canonical source repository
 * @copyright Copyright (c) 2012 Nicholas Calugar (http://socalnick.github.com)
 */

namespace ScnSocialAuthTest\Controller;

use ScnSocialAuth\Controller\UserController;
use PHPUnit_Framework_TestCase as TestCase;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;
use Zend\ServiceManager\ServiceManager;

class UserControllerTest extends TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $sm;

    /**
     * @var \Zend\Mvc\Controller\PluginManager
     */
    protected $pm;

    /**
     * @var \ScnSocialAuth\Controller\UserController
     */
    protected $controller;

    /**
     * @var \Zend\Mvc\MvcEvent;
     */
    protected $event;

    /**
     * @var \Zend\Http\PhpEnvironment\Request
     */
    protected $request;

    public function setUp()
    {
        $this->sm = new ServiceManager();
        $this->pm = new PluginManager();
        $this->event = new MvcEvent();
        $this->request = new Request();
        $this->controller = new UserController();
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->sm);
        $this->controller->setPluginManager($this->pm);

        $forwardPlugin = \Mockery::mock('Zend\Mvc\Controller\Plugin\Forward[dispatch]');
        $this->pm->setService('forward', $forwardPlugin);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    protected function dispatch($action, $params = array())
    {
        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array_merge(array('action' => $action), $params));
        $this->event->setRouteMatch($routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->dispatch($this->request);

        return $this->event->getResult();
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

    public function testLoginProxiesToZfcUserAndReturnsNonModelInterface()
    {
        /** @var $forwardPlugin \Mockery\MockInterface */
        $forwardPlugin = $this->pm->get('forward');
        $forwardPlugin->shouldReceive('dispatch')
            ->with('zfcuser', array('action' => 'login'))
            ->andReturn('zfc-user-login');

        $result = $this->dispatch('login');
        $this->assertEquals('zfc-user-login', $result);
    }

    public function testProviderLoginInvalidProvider()
    {
        $this->controller->setOptions(new ModuleOptions());
        $result = $this->dispatch('provider-login', array('provider' => 'facebook'));
        $this->assertEquals('Page not found', $result->content);
    }
}
