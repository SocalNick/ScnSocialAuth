<?php
namespace ScnSocialAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class HybridAuthController extends AbstractActionController
{
    public function indexAction()
    {
        \Hybrid_Endpoint::process();
    }
}
