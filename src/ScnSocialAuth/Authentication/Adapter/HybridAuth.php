<?php

namespace ScnSocialAuth\Authentication\Adapter;

use DateTime;
use Hybrid_Auth;
use ScnSocialAuth\Mapper\UserProvider;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Crypt\Password\Bcrypt;
use ZfcUser\Authentication\Adapter\AbstractAdapter;
use ZfcUser\Authentication\Adapter\AdapterChainEvent as AuthEvent;
use ZfcUser\Mapper\User as UserMapperInterface;
use ZfcUser\Options\UserServiceOptionsInterface;

class HybridAuth extends AbstractAdapter implements ServiceManagerAwareInterface
{
    /**
     * @var Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var UserServiceOptionsInterface
     */
    protected $zfcUserOptions;

    /**
     * @var UserProvider
     */
    protected $mapper;

    /**
     * @var UserMapperInterface
     */
    protected $zfcUserMapper;

    public function authenticate(AuthEvent $e)
    {
        if ($this->isSatisfied()) {
            $storage = $this->getStorage()->read();
            $e->setIdentity($storage['identity'])
              ->setCode(Result::SUCCESS)
              ->setMessages(array('Authentication successful.'));
            return;
        }

        $enabledProviders = $this->getOptions()->getEnabledProviders();
        $provider = $e->getRequest()->getQuery()->get('provider');

        if (empty($provider) || !in_array($provider, $enabledProviders)) {
            $e->setCode(Result::FAILURE)
              ->setMessages(array('Invalid provider'));
            $this->setSatisfied(false);
            return false;
        }

        try {
            $hybridAuth = $this->getHybridAuth();
            $adapter = $hybridAuth->authenticate($provider);
            $userProfile = $adapter->getUserProfile();
        } catch (\Exception $ex) {
            $e->setCode(Result::FAILURE)
              ->setMessages(array('Invalid provider'));
            $this->setSatisfied(false);
            return false;
        }

        if (!$userProfile) {
            $e->setCode(Result::FAILURE_IDENTITY_NOT_FOUND)
              ->setMessages(array('A record with the supplied identity could not be found.'));
            $this->setSatisfied(false);
            return false;
        }

        if (false == ($localUserProvider = $this->getMapper()->findUserByProviderId($userProfile->identifier, $provider))) {
            $userModelClass = $this->getZfcUserOptions()->getUserEntityClass();
            $localUser = new $userModelClass;
            //TODO We may want to provide different adapter implementation per provider
            $localUser->setEmail($userProfile->email ?: $userProfile->displayName)
                ->setDisplayName($userProfile->displayName)
                ->setPassword($provider);
            $result = $this->getZfcUserMapper()->insert($localUser);
            $localUserProvider = clone($this->getMapper()->getEntityPrototype());
            $localUserProvider->setUserId($localUser->getId())
                ->setProviderId($userProfile->identifier)
                ->setProvider($provider);
            $this->getMapper()->insert($localUserProvider);
        }

        $e->setIdentity($localUserProvider->getUserId());

        $this->setSatisfied(true);
        $storage = $this->getStorage()->read();
        $storage['identity'] = $e->getIdentity();
        $this->getStorage()->write($storage);
        $e->setCode(Result::SUCCESS)
          ->setMessages(array('Authentication successful.'))
          ->stopPropagation();
    }

	/**
     * Get the Hybrid_Auth object
     *
     * @return Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if (!$this->hybridAuth) {
            $this->hybridAuth = $this->getServiceManager()->get('HybridAuth');
        }
        return $this->hybridAuth;
    }

    /**
     * Set the Hybrid_Auth object
     *
     * @param Hybrid_Auth $hybridAuth
     * @return UserController
     */
    public function setHybridAuth(Hybrid_Auth $hybridAuth)
    {
        $this->hybridAuth = $hybridAuth;
        return $this;
    }

	/**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * set options
     *
     * @param ModuleOptions $options
     * @return HybridAuth
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * get options
     *
     * @return ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }
        return $this->options;
    }

    /**
     * @param UserServiceOptionsInterface $options
     * @return HybridAuth
     */
    public function setZfcUserOptions(UserServiceOptionsInterface $options)
    {
        $this->zfcUserOptions = $options;
        return $this;
    }

    /**
     * @return UserServiceOptionsInterface
     */
    public function getZfcUserOptions()
    {
        if (!$this->zfcUserOptions instanceof UserServiceOptionsInterface) {
            $this->setZfcUserOptions($this->getServiceManager()->get('zfcuser_module_options'));
        }
        return $this->zfcUserOptions;
    }

	/**
     * set mapper
     *
     * @param UserProvider $mapper
     * @return HybridAuth
     */
    public function setMapper(UserProvider $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * get mapper
     *
     * @return UserProvider
     */
    public function getMapper()
    {
        if (!$this->mapper instanceof UserProvider) {
            $this->setMapper($this->getServiceLocator()->get('ScnSocialAuth-UserProviderMapper'));
        }
        return $this->mapper;
    }

    /**
     * set zfcUserMapper
     *
     * @param UserMapperInterface $zfcUserMapper
     * @return HybridAuth
     */
    public function setZfcUserMapper(UserMapperInterface $zfcUserMapper)
    {
        $this->zfcUserMapper = $zfcUserMapper;
        return $this;
    }

    /**
     * get zfcUserMapper
     *
     * @return UserMapperInterface
     */
    public function getZfcUserMapper()
    {
        if (!$this->zfcUserMapper instanceof UserMapperInterface) {
            $this->setZfcUserMapper($this->getServiceLocator()->get('zfcuser_user_mapper'));
        }
        return $this->zfcUserMapper;
    }
}
