<?php
namespace ScnSocialAuth\Controller;

use Hybrid_Auth;
use ScnSocialAuth\Mapper\Exception as MapperException;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * @var \ZfcUser\Authentication\Adapter\AdapterChain
     */
    protected $scnAuthAdapterChain;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var \ZfcUser\Options\ModuleOptions
     */
    protected $zfcmoduleoptions;

    /*
     * @todo Make this dynamic / translation-friendly
     * @var string
     */
    protected $failedAddProviderMessage = 'Add provider failed. Please try again.';

    /**
     * @var callable $redirectCallback
     */
    protected $redirectCallback;

    /**
     * @param callable $redirectCallback
     */
    public function __construct($redirectCallback)
    {
        if (!is_callable($redirectCallback)) {
            throw new \InvalidArgumentException('You must supply a callable redirectCallback');
        }
        $this->redirectCallback = $redirectCallback;
    }

    public function addProviderAction()
    {
        // Make sure the provider is enabled, else 404
        $provider = $this->params('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }

        $authService = $this->zfcUserAuthentication()->getAuthService();

        // If user is not logged in, redirect to login page
        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $hybridAuth = $this->getHybridAuth();
        $adapter = $hybridAuth->authenticate($provider);

        if (!$adapter->isUserConnected()) {
            $this->flashMessenger()->setNamespace('zfcuser-index')->addMessage($this->failedAddProviderMessage);

            return $this->redirect()->toRoute('zfcuser');
        }

        $localUser = $authService->getIdentity();
        $userProfile = $adapter->getUserProfile();
        $accessToken = $adapter->getAccessToken();

        try {
            $this->getMapper()->linkUserToProvider($localUser, $userProfile, $provider, $accessToken);
        } catch (MapperException\ExceptionInterface $e) {
            $this->flashMessenger()->setNamespace('zfcuser-index')->addMessage($e->getMessage());
        }

        $redirect = $this->redirectCallback;

        return $redirect();
    }

    public function providerLoginAction()
    {
        $provider = $this->getEvent()->getRouteMatch()->getParam('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }
        $hybridAuth = $this->getHybridAuth();

        $query = array();
        if ($this->getZfcModuleOptions()->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $query = array('redirect' => $this->getRequest()->getQuery()->get('redirect'));
        }
        $redirectUrl = $this->url()->fromRoute('scn-social-auth-user/authenticate/provider', array('provider' => $provider), array('query' => $query));

        $adapter = $hybridAuth->authenticate(
            $provider,
            array(
                'hauth_return_to' => $redirectUrl,
            )
        );

        $redirect = $this->redirectCallback;

        return $redirect();
    }

    public function loginAction()
    {
        $zfcUserLogin = $this->forward()->dispatch('zfcuser', array('action' => 'login'));
        if (!$zfcUserLogin instanceof ModelInterface) {
            return $zfcUserLogin;
        }
        $viewModel = new ViewModel();
        $viewModel->addChild($zfcUserLogin, 'zfcUserLogin');
        $viewModel->setVariable('options', $this->getOptions());

        $redirect = false;
        if ($this->getZfcModuleOptions()->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $redirect = $this->getRequest()->getQuery()->get('redirect');
        }
        $viewModel->setVariable('redirect', $redirect);

        return $viewModel;
    }

    public function logoutAction()
    {
        Hybrid_Auth::logoutAllProviders();

        return $this->forward()->dispatch('zfcuser', array('action' => 'logout'));
    }

    public function providerAuthenticateAction()
    {
        // Get the provider from the route
        $provider = $this->getEvent()->getRouteMatch()->getParam('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }

        if (!$this->hybridAuth) {
            // This is likely user that cancelled login...
            return $this->redirect()->toRoute('zfcuser/login');
        }

        // For provider authentication, change the auth adapter in the ZfcUser Controller Plugin
        $this->zfcUserAuthentication()->setAuthAdapter($this->getScnAuthAdapterChain());

        // Adding the provider to request metadata to be used by HybridAuth adapter
        $this->getRequest()->setMetadata('provider', $provider);

        // Forward to the ZfcUser Authenticate action
        return $this->forward()->dispatch('zfcuser', array('action' => 'authenticate'));
    }

    public function registerAction()
    {
        $zfcUserRegister = $this->forward()->dispatch('zfcuser', array('action' => 'register'));
        if (!$zfcUserRegister instanceof ModelInterface) {
            return $zfcUserRegister;
        }
        $viewModel = new ViewModel();
        $viewModel->addChild($zfcUserRegister, 'zfcUserLogin');
        $viewModel->setVariable('options', $this->getOptions());

        $redirect = false;
        if ($this->getZfcModuleOptions()->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $redirect = $this->getRequest()->getQuery()->get('redirect');
        }
        $viewModel->setVariable('redirect', $redirect);

        return $viewModel;
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
        return $this->mapper;
    }

    /**
     * Get the Hybrid_Auth object
     *
     * @return Hybrid_Auth
     */
    public function getHybridAuth()
    {
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
     * Set the scnAuthAdapterChain
     *
     * @param \ZfcUser\Authentication\Adapter\AdapterChain
     * @return UserController
     */
    public function setScnAuthAdapterChain(\ZfcUser\Authentication\Adapter\AdapterChain $chain)
    {
        $this->scnAuthAdapterChain = $chain;

        return $this;
    }

    /**
     * Get the scnAuthAdapterChain
     *
     * @return \ZfcUser\Authentication\Adapter\AdapterChain
     */
    public function getScnAuthAdapterChain()
    {
        return $this->scnAuthAdapterChain;
    }

    /**
     * set options
     *
     * @param  ModuleOptions  $options
     * @return UserController
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
        return $this->options;
    }

    /**
     * @return \ZfcUser\Options\ModuleOptions
     */
    public function getZfcModuleOptions()
    {
        return $this->zfcmoduleoptions;
    }

    /**
     * @param \ZfcUser\Options\ModuleOptions $zfcmoduleoptions
     */
    public function setZfcModuleOptions($zfcmoduleoptions)
    {
        $this->zfcmoduleoptions = $zfcmoduleoptions;
    }
}
