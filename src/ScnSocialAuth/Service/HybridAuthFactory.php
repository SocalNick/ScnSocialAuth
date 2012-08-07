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
        /* @var $options \ScnSocialAuth\Options\ModuleOptions */
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
                    'Foursquare' => array(
                        'enabled' => $options->getFoursquareEnabled(),
                        'keys' => array(
                            'id' => $options->getFoursquareClientId(),
                            'secret' => $options->getFoursquareSecret(),
                        ),
                    ),
                    'Google' => array(
                        'enabled' => $options->getGoogleEnabled(),
                        'keys' => array(
                            'id' => $options->getGoogleClientId(),
                            'secret' => $options->getGoogleSecret(),
                        ),
                        'scope' => $options->getGoogleScope(),
                    ),
                    'LinkedIn' => array(
                        'enabled' => $options->getLinkedInEnabled(),
                        'keys' => array(
                            'key' => $options->getLinkedInClientId(),
                            'secret' => $options->getLinkedInSecret(),
                        ),
                    ),
                    'Twitter' => array(
                        'enabled' => $options->getTwitterEnabled(),
                        'keys' => array(
                            'key' => $options->getTwitterConsumerKey(),
                            'secret' => $options->getTwitterConsumerSecret(),
                        ),
                    ),
                    'Yahoo' => array(
                        'enabled' => $options->getYahooEnabled(),
                        'keys' => array(
                            'key' => $options->getYahooClientId(),
                            'secret' => $options->getYahooSecret(),
                        ),
                    ),
                ),
            )
        );

        return $hybridAuth;
    }
}
