<?php

$finder = PhpCsFixer\Finder::create()
    ->in('./bin')
    ->in('./config')
    ->in('./data/migrations')
    ->in('./public')
    ->in('./src');

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony'               => true,
        '@PSR2'                  => true,
        'array_syntax'           => ['syntax' => 'short'],
        'concat_space'           => ['spacing' => 'one'],
        'binary_operator_spaces' => ['default' => null],
        'yoda_style'             => null,
        'no_superfluous_phpdoc_tags' => false,
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
