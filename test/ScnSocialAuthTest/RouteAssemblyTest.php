<?php

namespace ScnSocialAuthTest;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class RouteAssemblyTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            array(
                'module_listener_options' => array(
                    'module_paths' => array(
                        'ScnSocialAuth' => dirname(dirname(dirname(__DIR__))),
                    ),
                ),
                'modules' => array(
                    'ScnSocialAuth',
                ),
            )
        );
        parent::setUp();
    }

    public function testCanAssembleAuthenticationRouteWithProvider()
    {
        $sm = $this->getApplicationServiceLocator();
        $router = $sm->get('Router');
        $url = $router->assemble(
            array(),
            array(
                'name' => 'scn-social-auth-user/authenticate',
                'query' => array(
                    'provider' => 'facebook',
                ),
            )
        );

        $this->assertEquals('/user/authenticate?provider=facebook', $url);
    }

    public function testCanAssembleAuthenticationRouteWithRedirect()
    {
        $sm = $this->getApplicationServiceLocator();
        $router = $sm->get('Router');
        $url = $router->assemble(
            array(),
            array(
                'name' => 'scn-social-auth-user/authenticate',
                'query' => array(
                    'provider' => 'facebook',
                    'redirect' => 'another-url',
                ),
            )
        );

        $this->assertEquals('/user/authenticate?provider=facebook&redirect=another-url', $url);
    }
}
