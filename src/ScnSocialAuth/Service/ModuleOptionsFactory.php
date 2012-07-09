<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   SIgnCom
 * @package    SIgnCom_Controller
 * @copyright  Copyright (c) 2006-2011 IGN Entertainment, Inc. (http://corp.ign.com/)
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Configuration');
        return new Options\ModuleOptions(isset($config['scn-social-auth']) ? $config['scn-social-auth'] : array());
    }
}
