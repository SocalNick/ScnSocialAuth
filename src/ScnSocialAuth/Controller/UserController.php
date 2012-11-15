<?php
namespace ScnSocialAuth\Controller;

use Hybrid_Auth;
use ScnSocialAuth\Options\ModuleOptions;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    /**
     * @var Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     *
     * @var ZfcUserModuleOptions
     */
    protected $zfcUserOptions;

    public function providerLoginAction()
    {
        $provider = $this->getEvent()->getRouteMatch()->getParam('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }
        $hybridAuth = $this->getHybridAuth();

        $query = array('provider' => $provider);
        if ($this->getZfcUserOptions()->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $query = array_merge($query, array('redirect' => $this->getRequest()->getQuery()->get('redirect')));
        }
        $redirectUrl = $this->url()->fromRoute('scn-social-auth-user/authenticate/query', $query);

        $adapter = $hybridAuth->authenticate(
            $provider,
            array(
                'hauth_return_to' => $redirectUrl,
            )
        );

        return $this->redirect()->toUrl($redirectUrl);
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

        if ($this->getZfcUserOptions()->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $redirect = $this->getRequest()->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        $viewModel->setVariable('redirect', $redirect);

        return $viewModel;
    }

    public function logoutAction()
    {
        Hybrid_Auth::logoutAllProviders();

        return $this->forward()->dispatch('zfcuser', array('action' => 'logout'));
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

        return $viewModel;
    }

    /**
     * Get the Hybrid_Auth object
     *
     * @return Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if (!$this->hybridAuth) {
            $this->hybridAuth = $this->getServiceLocator()->get('HybridAuth');
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
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }

        return $this->options;
    }

    /**
     * set options
     *
     * @param  ZfcUserModuleOptions  $options
     * @return UserController
     */
    public function setZfcUserOptions(ZfcUserModuleOptions $options)
    {
        $this->zfcUserOptions = $options;

        return $this;
    }

    /**
     * get ZfcUser options
     *
     * @return ZfcUserModuleOptions
     */
    public function getZfcUserOptions()
    {
        if (!$this->zfcUserOptions instanceof ZfcUserModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('zfcuser_module_options'));
        }

        return $this->zfcUserOptions;
    }
}
