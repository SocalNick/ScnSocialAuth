<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use Hybrid_Auth;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
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
        // Making sure the SessionManager is initialized
        // before creating HybridAuth components
        $sessionManager = $services->get('ScnSocialAuth_ZendSessionManager')->start();

        /* @var $options \ScnSocialAuth\Options\ModuleOptions */
        $options = $services->get('ScnSocialAuth-ModuleOptions');

        $baseUrl = $this->getBaseUrl($services);

        $hybridAuth = new Hybrid_Auth(
            array(
                'base_url' => $baseUrl,
                'providers' => array(
                    'Facebook' => array(
                        'enabled' => $options->getFacebookEnabled(),
                        'keys' => array(
                            'id' => $options->getFacebookClientId(),
                            'secret' => $options->getFacebookSecret(),
                        ),
                        'scope' => $options->getFacebookScope(),
                        'display' => $options->getFacebookDisplay(),
                        'trustForwarded' => $options->getFacebookTrustForwarded(),
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
                        'hd' => $options->getGoogleHd(),
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
                    'Tumblr' => array(
                        'enabled' => $options->getTumblrEnabled(),
                        'keys' => array(
                            'key' => $options->getTumblrConsumerKey(),
                            'secret' => $options->getTumblrConsumerSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Tumblr',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Tumblr.php'),
                        ),
                    ),
                    'Mailru' => array(
                        'enabled' => $options->getMailruEnabled(),
                        'keys' => array(
                            'id' => $options->getMailruClientId(),
                            'secret' => $options->getMailruSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Mailru',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Mailru.php'),
                        ),
                    ),
                    'Odnoklassniki' => array(
                        'enabled' => $options->getOdnoklassnikiEnabled(),
                        'keys' => array(
                            'id' => $options->getOdnoklassnikiAppId(),
                            'key' => $options->getOdnoklassnikiKey(),
                            'secret' => $options->getOdnoklassnikiSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Odnoklassniki',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Odnoklassniki.php'),
                        ),
                    ),
                    'Vkontakte' => array(
                        'enabled' => $options->getVkontakteEnabled(),
                        'keys' => array(
                            'id' => $options->getVkontakteAppId(),
                            'secret' => $options->getVkontakteSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Vkontakte',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Vkontakte.php'),
                        ),
                    ),
                    'Yandex' => array(
                        'enabled' => $options->getYandexEnabled(),
                        'keys' => array(
                            'id' => $options->getYandexAppId(),
                            'secret' => $options->getYandexSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Yandex',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Yandex.php'),
                        ),
                    ),
                    'Instagram' => array(
                        'enabled' => $options->getInstagramEnabled(),
                        'keys' => array(
                            'id' => $options->getInstagramClientId(),
                            'secret' => $options->getInstagramClientSecret(),
                        ),
                        'wrapper' => array(
                            'class' => 'Hybrid_Providers_Instagram',
                            'path' => realpath(__DIR__ . '/../HybridAuth/Provider/Instagram.php'),
                        ),
                    ),
                ),
            )
        );

        return $hybridAuth;
    }

    public function getBaseUrl(ServiceLocatorInterface $services)
    {
        $router = $services->get('Router');
        if (!$router instanceof TreeRouteStack) {
            throw new ServiceNotCreatedException('TreeRouteStack is required to create a fully qualified base url for HybridAuth');
        }

        $request = $services->get('Request');
        if (!$router->getRequestUri() && method_exists($request, 'getUri')) {
            $router->setRequestUri($request->getUri());
        }
        if (!$router->getBaseUrl() && method_exists($request, 'getBaseUrl')) {
            $router->setBaseUrl($request->getBaseUrl());
        }

        return $router->assemble(
            array(),
            array(
                'name' => 'scn-social-auth-hauth',
                'force_canonical' => true,
            )
        );
    }
}
