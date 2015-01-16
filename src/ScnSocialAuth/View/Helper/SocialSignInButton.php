<?php
namespace ScnSocialAuth\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SocialSignInButton extends AbstractHelper
{
    public function __invoke($provider, $redirect = false)
    {
        $name = 'scn-social-auth-user/login/provider';
        $params = array('provider' => $provider);
        $options = array();

        if ($redirect) {
            $options = array(
                'query' => array(
                    'redirect' => $redirect,
                ),
            );
        }

        $url = $this->view->url($name, $params, $options);

        echo '<a class="btn" href="' . $url . '">' . ucfirst($provider) . '</a>';
    }
}
