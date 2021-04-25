<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests/debug')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'no_unused_imports' => true
    ])
    ->setFinder($finder);
