<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->notName('autoload_classmap.php')
    ->notName('autoload_function.php')
    ->notName('LICENSE')
    ->notName('README.md')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('*.xml')
;

return PhpCsFixer\Config::create()
    ->setFinder($finder)
;
