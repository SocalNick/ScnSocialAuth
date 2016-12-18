<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Controller\Plugin\ScnSocialAuthProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class ProviderControllerPluginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $mapper = $serviceManager->getServiceLocator()->get('ScnSocialAuth-UserProviderMapper');

        $controllerPlugin = new ScnSocialAuthProvider();
        $controllerPlugin->setMapper($mapper);

        return $controllerPlugin;
    }
}
