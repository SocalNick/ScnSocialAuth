<?php
namespace ScnSocialAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FacebookController extends AbstractActionController
{
    /**
     * @var Hybrid_Auth
     */
    protected $hybridAuth;

    public function getHybridAuth()
    {
        if (!$this->hybridAuth) {
            $this->hybridAuth = $this->getServiceLocator()->get('HybridAuth');
        }
        return $this->hybridAuth;
    }

    public function setHybridAuth(\Hybrid_Auth $hybridAuth)
    {
        $this->hybridAuth = $hybridAuth;
        return $this;
    }

    public function loginAction()
    {
        $hybridAuth = $this->getHybridAuth();
        $adapter = $hybridAuth->authenticate('facebook');
        return array('user' => $adapter->getUserProfile());
    }
}
