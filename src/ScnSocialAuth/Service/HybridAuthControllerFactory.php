<?php
/**
 * ScnSocialAuth Module
 *
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */

namespace ScnSocialAuth\Service;

use RuntimeException;
use ScnSocialAuth\Controller\HybridAuthController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class HybridAuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        // These class_exists calls take care of autoloading
        if (!class_exists('Hybrid_Auth') || !class_exists('Hybrid_Endpoint')) {
            throw new RuntimeException('Unable to load Hybrid_Auth and Hybrid_Endpoint');
        }

        $controller = new HybridAuthController();

        return $controller;
    }
}
