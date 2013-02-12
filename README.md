ScnSocialAuth
=============
Uses the HybridAuth PHP library to Enable authentication via Google, Facebook, Twitter, Yahoo!, etc for the ZfcUser ZF2 module.

[![Build Status](https://travis-ci.org/SocalNick/ScnSocialAuth.png)](https://travis-ci.org/SocalNick/ScnSocialAuth)

Requirements
------------
* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)
* [ZfcBase](https://github.com/ZF-Commons/ZfcBase) (latest master)
* [ZfcUser](https://github.com/ZF-Commons/ZfcUser) (latest master)
* [HybridAuth](https://github.com/hybridauth/hybridauth) (latest master)
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

Installation
------------
It is recommended to add this module to your Zend Framework 2 application using Composer. After cloning [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication), change the composer minimum-stability setting to "dev" and add "socalnick/scn-social-auth" to list of requirements, then run php composer.phar install/update. Your composer.json should look something like this:
```
{
    "name": "zendframework/skeleton-application",
    "description": "Skeleton Application for ZF2",
    "license": "BSD-3-Clause",
    "keywords": [
        "framework",
        "zf2"
    ],
    "minimum-stability": "dev",
    "homepage": "http://framework.zend.com/",
    "require": {
        "php": ">=5.3.3",
        "zendframework/zendframework": "dev-master",
        "socalnick/scn-social-auth": "dev-master"
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
