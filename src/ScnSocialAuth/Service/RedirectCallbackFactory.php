<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Controller\RedirectCallback;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class RedirectCallbackFactory implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $router = $serviceLocator->get('Router');
    $application = $serviceLocator->get('Application');
    $options = $serviceLocator->get('zfcuser_module_options');

    return new RedirectCallback($application, $router, $options);
  }
}
