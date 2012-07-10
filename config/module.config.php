<?php
return array(
    'controllers' => array(
        'factories' => array(
            'ScnSocialAuth-HybridAuth' => 'ScnSocialAuth\Service\HybridAuthControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'scn-social-auth-hauth' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/scn-social-auth/hauth',
                    'defaults' => array(
                        'controller' => 'ScnSocialAuth-HybridAuth',
                        'action'     => 'index',
                    ),
                ),
            ),
            'scn-social-auth-facebook-login' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/scn-social-auth/facebook/login',
                    'defaults' => array(
                        'controller' => 'ScnSocialAuth-Facebook',
                        'action'     => 'login',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'HybridAuth' => 'ScnSocialAuth\Service\HybridAuthFactory',
            'ScnSocialAuth-ModuleOptions' => 'ScnSocialAuth\Service\ModuleOptionsFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'socialSignInButton' => 'ScnSocialAuth\View\Helper\SocialSignInButton',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'scn-social-auth' => __DIR__ . '/../view'
        ),
    ),
);