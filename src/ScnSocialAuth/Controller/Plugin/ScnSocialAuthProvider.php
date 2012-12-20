<?php

namespace ScnSocialAuth\Controller\Plugin;

use ScnSocialAuth\Mapper\UserProviderInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Entity\UserInterface;

class ScnSocialAuthProvider extends AbstractPlugin implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * Returns a UserProviderInterface for $user and $provider
     *
     * @param UserInterface $user
     * @param string        $provider
     * @param UserProviderInterface|false
     */
    public function getProvider(UserInterface $user, $provider)
    {
        return $this->getMapper()->findProviderByUser($user, $provider);
    }

    /**
     * Returns an array of UserProviderInterface for $user
     *
     * @param UserInterface $user
     * @param UserProviderInterface|false
     */
    public function getProviders(UserInterface $user)
    {
        return $this->getMapper()->findProvidersByUser($user);
    }

    /**
     * set mapper
     *
     * @param  UserProviderInterface $mapper
     * @return HybridAuth
     */
    public function setMapper(UserProviderInterface $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return UserProviderInterface
     */
    public function getMapper()
    {
        if (!$this->mapper instanceof UserProviderInterface) {
            $this->setMapper($this->getServiceManager()->get('ScnSocialAuth-UserProviderMapper'));
        }

        return $this->mapper;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager->getServiceLocator();
    }

    /**
     * Set service manager instance
     *
     * @param  ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
