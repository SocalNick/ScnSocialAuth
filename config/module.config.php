<?php
return array(
    'controllers' => array(
        'factories' => array(
            'ScnSocialAuth-HybridAuth' => 'ScnSocialAuth\Service\HybridAuthControllerFactory',
            'ScnSocialAuth-User' => 'ScnSocialAuth\Service\UserControllerFactory',
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
            'scn-social-auth-user' => array(
                'type' => 'Literal',
                'priority' => 2000,
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'ScnSocialAuth-User',
                                'action'     => 'login',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'facebook' => array(
                                'type' => 'Literal',
                                'options' => array(
                                	'route' => '/facebook',
                                    'defaults' => array(
                                    	'controller' => 'ScnSocialAuth-User',
                                        'action' => 'facebook-login',
                                    ),
                                ),
                            ),
                            'google' => array(
                                'type' => 'Literal',
                                'options' => array(
                                	'route' => '/google',
                                    'defaults' => array(
                                    	'controller' => 'ScnSocialAuth-User',
                                        'action' => 'google-login',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'ScnSocialAuth-User',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'ScnSocialAuth-User',
                                'action'     => 'register',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'HybridAuth' => 'ScnSocialAuth\Service\HybridAuthFactory',
            'ScnSocialAuth-ModuleOptions' => 'ScnSocialAuth\Service\ModuleOptionsFactory',
            'ScnSocialAuth-UserProviderMapper' => 'ScnSocialAuth\Service\UserProviderMapperFactory',
    		'ScnSocialAuth\Authentication\Adapter\HybridAuth' => 'ScnSocialAuth\Service\HybridAuthAdapterFactory',
    		'ZfcUser\Authentication\Adapter\AdapterChain' => 'ScnSocialAuth\Service\AuthenticationAdapterChainFactory',
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