<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Authentication\Adapter\AdapterChainServiceFactory;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class AuthenticationAdapterChainFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        // Temporarily replace the adapters in the module options with the HybridAuth adapter
        $zfcUserModuleOptions = $services->get('zfcuser_module_options');
        $currentAuthAdapters = $zfcUserModuleOptions->getAuthAdapters();
        $zfcUserModuleOptions->setAuthAdapters(array(100 => 'ScnSocialAuth\Authentication\Adapter\HybridAuth'));

        // Create a new adapter chain with HybridAuth adapter
        $factory = new AdapterChainServiceFactory();
        $chain = $factory->createService($services);

        // Reset the adapters in the module options
        $zfcUserModuleOptions->setAuthAdapters($currentAuthAdapters);

        return $chain;
    }
}
