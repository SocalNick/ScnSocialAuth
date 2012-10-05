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
        $factory = new AdapterChainServiceFactory();
        $chain = $factory->createService($services);
        $adapter = $services->get('ScnSocialAuth\Authentication\Adapter\HybridAuth');
        $chain->getEventManager()->attach('authenticate', array($adapter, 'authenticate'), 1000);

        return $chain;
    }
}
