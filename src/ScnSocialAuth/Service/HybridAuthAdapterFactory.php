<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use ScnSocialAuth\Authentication\Adapter\HybridAuth as HybridAuthAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class HybridAuthAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $moduleOptions = $services->get('ScnSocialAuth-ModuleOptions');
        $zfcUserOptions = $services->get('zfcuser_module_options');

        $mapper = $services->get('ScnSocialAuth-UserProviderMapper');
        $zfcUserMapper = $services->get('zfcuser_user_mapper');

        $adapter = new HybridAuthAdapter();
        $adapter->setOptions($moduleOptions);
        $adapter->setZfcUserOptions($zfcUserOptions);
        $adapter->setMapper($mapper);
        $adapter->setZfcUserMapper($zfcUserMapper);

        return $adapter;
    }
}
