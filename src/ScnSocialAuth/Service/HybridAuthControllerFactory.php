<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Controller\HybridAuthController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   SIgnCom
 * @package    SIgnCom_Controller
 * @copyright  Copyright (c) 2006-2011 IGN Entertainment, Inc. (http://corp.ign.com/)
 */
class HybridAuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $options = $services->get('ScnSocialAuth-ModuleOptions');

        require_once $options->getHybridAuthPath()
            . '/Hybrid'
            . '/Auth.php';

        require_once $options->getHybridAuthPath()
            . '/Hybrid'
            . '/Endpoint.php';

        $controller = new HybridAuthController();

        return $controller;
    }
}
