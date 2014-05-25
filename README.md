ScnSocialAuth
=============
Uses the HybridAuth PHP library to Enable authentication via Google, Facebook, Twitter, Yahoo!, etc for the ZfcUser ZF2 module.

[![Build Status](https://travis-ci.org/SocalNick/ScnSocialAuth.png)](https://travis-ci.org/SocalNick/ScnSocialAuth) [![Latest Stable Version](https://poser.pugx.org/socalnick/scn-social-auth/v/stable.png)](https://packagist.org/packages/socalnick/scn-social-auth) [![Total Downloads](https://poser.pugx.org/socalnick/scn-social-auth/downloads.png)](https://packagist.org/packages/socalnick/scn-social-auth)

Requirements
------------
* [Zend Framework 2](https://github.com/zendframework/zf2) (2.*)
* [ZfcBase](https://github.com/ZF-Commons/ZfcBase) (0.1.*)
* [ZfcUser](https://github.com/ZF-Commons/ZfcUser) (1.0.*)
* [HybridAuth](https://github.com/hybridauth/hybridauth) (2.2.*)
* Extension php_curl enabled in php.ini

Features
--------
* Login with AOL [NO LONGER SUPPORTED]
* Login with Facebook [COMPLETE]
* Login with Foursquare [COMPLETE]
* Login with Github [COMPLETE]
* Login with Google [COMPLETE]
* Login with LinkedIn [COMPLETE]
* Login with Live [INCOMPLETE]
* Login with MySpace [INCOMPLETE]
* Login with OpenID [INCOMPLETE]
* Login with Twitter [COMPLETE]
* Login with Yahoo! [COMPLETE]
* Login with Tumblr [COMPLETE]
* Login with Mail.Ru [COMPLETE]
* Login with Odnoklassniki [COMPLETE]
* Login with VKontakte [COMPLETE]
* Login with Yandex [COMPLETE]
* Login with Instagram [COMPLETE]

Installation
------------
It is recommended to add this module to your Zend Framework 2 application using Composer. After cloning [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication), add "socalnick/scn-social-auth" to list of requirements, then run php composer.phar install/update. Your composer.json should look something like this:
```
{
    "name": "zendframework/skeleton-application",
    "description": "Skeleton Application for ZF2",
    "license": "BSD-3-Clause",
    "keywords": [
        "framework",
        "zf2"
    ],
    "homepage": "http://framework.zend.com/",
    "require": {
        "php": ">=5.3.3",
        "zendframework/zendframework": "2.*",
        "socalnick/scn-social-auth": "1.*"
    }
}
```

Next add the required modules to config/application.config.php:
```
<?php
return array(
    'modules' => array(
        'Application',
        'ScnSocialAuth',
        'ZfcBase',
        'ZfcUser',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
```

Import the schemas for ZfcUser (`./vendor/zf-commons/zfc-user/data/schema.sql`) and ScnSocialAuth (`./vendor/socalnick/scn-social-auth/data/schema.sql`).

If you do not already have a valid Zend\Db\Adapter\Adapter in your service
manager configuration, put the following in `./config/autoload/database.local.php`:
```
<?php

$dbParams = array(
    'database'  => 'changeme',
    'username'  => 'changeme',
    'password'  => 'changeme',
    'hostname'  => 'changeme',
);

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
                return new Zend\Db\Adapter\Adapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                    'database'  => $dbParams['database'],
                    'username'  => $dbParams['username'],
                    'password'  => $dbParams['password'],
                    'hostname'  => $dbParams['hostname'],
                ));
            },
        ),
    ),
);
```

If you do not already have a valid Zend\Session\SessionManager in your service
manager configuration, put the following in `./config/autoload/session.local.php`:
```
<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'Zend\Session\SessionManager' => 'Zend\Session\SessionManager',
        ),
    ),
);
```

Options
-------
Make sure to check the options available in ZfcUser: https://github.com/ZF-Commons/ZfcUser#options

The ScnSocialAuth module has two files that allow you to configure supported providers.
After installing ScnSocialAuth, copy
`./vendor/socalnick/scn-social-auth/config/scn-social-auth.global.php.dist` to
`./config/autoload/scn-social-auth.global.php` and change the values as desired.
Also copy
`./vendor/socalnick/scn-social-auth/config/scn-social-auth.local.php.dist` to
`./config/autoload/scn-social-auth.local.php` and change the values as desired.
