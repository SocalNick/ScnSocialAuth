<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use Hybrid_Auth;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class HybridAuthFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $options = $services->get('ScnSocialAuth-ModuleOptions');

        $router = $services->get('Router');
        $baseUrl = $router->assemble(
            array(),
            array(
            	'name' => 'home',
                'force_canonical' => true,
            )
        );

        $hybridAuth = new Hybrid_Auth(
            array(
                'base_url' => $baseUrl . 'scn-social-auth/hauth',
                'providers' => array(
                    'Facebook' => array(
                        'enabled' => $options->getFacebookEnabled(),
                        'keys' => array(
                            'id' => $options->getFacebookClientId(),
                            'secret' => $options->getFacebookSecret(),
                        ),
                        'scope' => $options->getFacebookScope(),
                        'display' => $options->getFacebookDisplay(),
                    ),
                ),
            )
        );

        return $hybridAuth;
    }
}
