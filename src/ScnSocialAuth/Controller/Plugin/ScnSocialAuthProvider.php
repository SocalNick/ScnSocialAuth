<?php

namespace ScnSocialAuth\Controller\Plugin;

use ScnSocialAuth\Mapper\UserProviderInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Entity\UserInterface;

class ScnSocialAuthProvider extends AbstractPlugin implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * Returns a UserProviderInterface for $user and $provider
     *
     * @param UserInterface $user
     * @param string        $provider
     */
    public function getProvider(UserInterface $user, $provider)
    {
        return $this->getMapper()->findProviderByUser($user, $provider);
    }

    /**
     * Returns an array of UserProviderInterface for $user
     *
     * @param UserInterface $user
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
            $this->setMapper($this->getServiceLocator()->get('ScnSocialAuth-UserProviderMapper'));
        }

        return $this->mapper;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator->getServiceLocator();
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
