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
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Configuration');

        $options = array();

        if (isset($config['scn-social-auth'])) {
            $options = $config['scn-social-auth'];
        }

        // Add use_redirect_parameter_if_present option from zfc-user
        if (isset($config['zfc-user'])) {
            $options = array_merge($options, array('use_redirect_parameter_if_present' => $config['zfc-user']['use_redirect_parameter_if_present']));
        }

        return new Options\ModuleOptions($options);
    }
}
