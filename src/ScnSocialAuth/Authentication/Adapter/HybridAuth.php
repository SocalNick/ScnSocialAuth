<?php

namespace ScnSocialAuth\Authentication\Adapter;

use Hybrid_Auth;
use ScnSocialAuth\Authentication\Adapter\Exception;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Authentication\Adapter\AbstractAdapter;
use ZfcUser\Authentication\Adapter\AdapterChainEvent as AuthEvent;
use ZfcUser\Mapper\UserInterface as UserMapperInterface;
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
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var UserMapperInterface
     */
    protected $zfcUserMapper;

    public function authenticate(AuthEvent $authEvent)
    {
        if ($this->isSatisfied()) {
            $storage = $this->getStorage()->read();
            $authEvent->setIdentity($storage['identity'])
              ->setCode(Result::SUCCESS)
              ->setMessages(array('Authentication successful.'));

            return;
        }

        $enabledProviders = $this->getOptions()->getEnabledProviders();
        $provider = $authEvent->getRequest()->getQuery()->get('provider');

        if (empty($provider) || !in_array($provider, $enabledProviders)) {
            $authEvent->setCode(Result::FAILURE)
              ->setMessages(array('Invalid provider'));
            $this->setSatisfied(false);

            return false;
        }

        try {
            $hybridAuth = $this->getHybridAuth();
            $adapter = $hybridAuth->authenticate($provider);
            $userProfile = $adapter->getUserProfile();
        } catch (\Exception $ex) {
            $authEvent->setCode(Result::FAILURE)
              ->setMessages(array('Invalid provider'));
            $this->setSatisfied(false);

            return false;
        }

        if (!$userProfile) {
            $authEvent->setCode(Result::FAILURE_IDENTITY_NOT_FOUND)
              ->setMessages(array('A record with the supplied identity could not be found.'));
            $this->setSatisfied(false);

            return false;
        }

        $localUserProvider = $this->getMapper()->findUserByProviderId($userProfile->identifier, $provider);
        if (false == $localUserProvider) {
            $method = $provider.'ToLocalUser';
            if (method_exists($this, $method)) {
                try {
                    $localUser = $this->$method($userProfile);
                } catch (Exception\RuntimeException $ex) {
                    $authEvent->setCode($ex->getCode())
                        ->setMessages(array($ex->getMessage()))
                        ->stopPropagation();
                    $this->setSatisfied(false);

                    return false;
                }
            } else {
                $localUser = $this->instantiateLocalUser();
                $localUser->setDisplayName($userProfile->displayName)
                          ->setPassword($provider);
                if ($userProfile->emailVerified) $localUser->setEmail($userProfile->emailVerified);
                $result = $this->getZfcUserMapper()->insert($localUser);
            }
            $localUserProvider = clone($this->getMapper()->getEntityPrototype());
            $localUserProvider->setUserId($localUser->getId())
                ->setProviderId($userProfile->identifier)
                ->setProvider($provider);
            $this->getMapper()->insert($localUserProvider);
        }

        $authEvent->setIdentity($localUserProvider->getUserId());

        $this->setSatisfied(true);
        $storage = $this->getStorage()->read();
        $storage['identity'] = $authEvent->getIdentity();
        $this->getStorage()->write($storage);
        $authEvent->setCode(Result::SUCCESS)
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
     * @param  Hybrid_Auth    $hybridAuth
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
     * @param  ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * set options
     *
     * @param  ModuleOptions $options
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
     * @param  UserServiceOptionsInterface $options
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
     * set zfcUserMapper
     *
     * @param  UserMapperInterface $zfcUserMapper
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

    /**
     * Utility function to instantiate a fresh local user object
     *
     * @return mixed
     */
    protected function instantiateLocalUser()
    {
        $userModelClass = $this->getZfcUserOptions()->getUserEntityClass();

        return new $userModelClass;
    }

    // Provider specific methods

    protected function facebookToLocalUser($userProfile)
    {
        if (!isset($userProfile->emailVerified)) {
            throw new Exception\RuntimeException(
                'Please verify your email with Facebook before attempting login',
                Result::FAILURE_CREDENTIAL_INVALID
            );
        }
        $mapper = $this->getZfcUserMapper();
        if (false != ($localUser = $mapper->findByEmail($userProfile->emailVerified))) {
            return $localUser;
        }
        $localUser = $this->instantiateLocalUser();
        $localUser->setEmail($userProfile->emailVerified)
            ->setDisplayName($userProfile->displayName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }

    protected function foursquareToLocalUser($userProfile)
    {
        if (!isset($userProfile->emailVerified)) {
            throw new Exception\RuntimeException(
                'Please verify your email with Foursquare before attempting login',
                Result::FAILURE_CREDENTIAL_INVALID
            );
        }
        $mapper = $this->getZfcUserMapper();
        if (false != ($localUser = $mapper->findByEmail($userProfile->emailVerified))) {
            return $localUser;
        }
        $localUser = $this->instantiateLocalUser();
        $localUser->setEmail($userProfile->emailVerified)
            ->setDisplayName($userProfile->displayName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }

    protected function googleToLocalUser($userProfile)
    {
        if (!isset($userProfile->emailVerified)) {
            throw new Exception\RuntimeException(
                'Please verify your email with Google before attempting login',
                Result::FAILURE_CREDENTIAL_INVALID
            );
        }
        $mapper = $this->getZfcUserMapper();
        if (false != ($localUser = $mapper->findByEmail($userProfile->emailVerified))) {
            return $localUser;
        }
        $localUser = $this->instantiateLocalUser();
        $localUser->setEmail($userProfile->emailVerified)
            ->setDisplayName($userProfile->displayName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }

    protected function linkedInToLocalUser($userProfile)
    {
        $localUser = $this->instantiateLocalUser();
        $localUser->setDisplayName($userProfile->displayName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }

    protected function twitterToLocalUser($userProfile)
    {
        $localUser = $this->instantiateLocalUser();
        $localUser->setUsername($userProfile->displayName)
            ->setDisplayName($userProfile->firstName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }

    protected function yahooToLocalUser($userProfile)
    {
        $localUser = $this->instantiateLocalUser();
        $localUser->setDisplayName($userProfile->displayName)
            ->setPassword(__FUNCTION__);
        $result = $this->getZfcUserMapper()->insert($localUser);

        return $localUser;
    }
}
