<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Controller\UserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $mapper = $controllerManager->getServiceLocator()->get('ScnSocialAuth-UserProviderMapper');
        $moduleOptions = $controllerManager->getServiceLocator()->get('ScnSocialAuth-ModuleOptions');
        $redirectCallback = $controllerManager->getServiceLocator()->get('zfcuser_redirect_callback');

        $controller = new UserController($redirectCallback);
        $controller->setMapper($mapper);
        $controller->setOptions($moduleOptions);

        try {
          $hybridAuth = $controllerManager->getServiceLocator()->get('HybridAuth');
          $controller->setHybridAuth($hybridAuth);
        } catch (\Zend\ServiceManager\Exception\ServiceNotCreatedException $e) {
          // This is likely the user cancelling login...
        }

        return $controller;
    }
}
