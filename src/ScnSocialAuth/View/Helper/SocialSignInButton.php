<?php
namespace ScnSocialAuth\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SocialSignInButton extends AbstractHelper
{
    public function __invoke($provider)
    {
        echo '<a class="btn" href="' . $this->view->url('scn-social-auth-user/login/' . strtolower($provider)) . '">' . $provider . '</a>';
    }
}
