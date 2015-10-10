<?php
namespace ScnSocialAuthtest;

use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
    protected static $serviceManager;

    public static function init()
    {
        static::initAutoloader();
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        }

        $zf2Path = getenv('ZF2_PATH') ?: (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/zendframework') ? $vendorPath . '/zendframework' : false));

        if (!$zf2Path) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
        }

        if (!isset($loader)) {
            throw new RuntimeException('Unable to run tests without composer autoloader');
        }

        $loader->add('Zend', $zf2Path . '/Zend');
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }

        return $dir . '/' . $path;
    }
}

Bootstrap::init();
