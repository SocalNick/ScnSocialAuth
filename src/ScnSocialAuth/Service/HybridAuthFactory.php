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
        try {
            $baseUrl = $router->assemble(
                array(),
                array(
                    'name' => $options->getHomeRoute(),
                    'force_canonical' => true,
                )
            );
        } catch (\Zend\Mvc\Router\Exception\RuntimeException $e) {
            throw new \Zend\Mvc\Router\Exception\RuntimeException(
                    $e->getMessage() . '. ' .
                    'Please set your correct home route key in the scn-social-auth.local.php config file.');
        }

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
                    'GitHub' => array(
                        'enabled' => $options->getGithubEnabled(),
                        'keys' => array(
                            'id' => $options->getGithubClientId(),
                            'secret' => $options->getGithubSecret(),
                        ),
                        'scope' => $options->getGithubScope(),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_GitHub',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/GitHub.php'),
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
