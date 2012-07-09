<?php
namespace ScnSocialAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HybridAuthController extends AbstractActionController
{
    public function indexAction()
    {
        \Hybrid_Endpoint::process();
    }
}
