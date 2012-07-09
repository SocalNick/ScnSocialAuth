<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Controller\FacebookController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   SIgnCom
 * @package    SIgnCom_Controller
 * @copyright  Copyright (c) 2006-2011 IGN Entertainment, Inc. (http://corp.ign.com/)
 */
class FacebookControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $hybridAuth = $services->get('HybridAuth');

        $controller = new FacebookController();
        $controller->setHybridAuth($hybridAuth);

        return $controller;
    }
}
