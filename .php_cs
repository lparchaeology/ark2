<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    '@PHP70Migration' => true,
    'array_syntax' => ['syntax' => 'short'],
    'combine_consecutive_unsets' => true,
    'no_short_echo_tag' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_order' => true,
    'semicolon_after_instruction' => true,
    'blank_line_before_statement' => [],
];

$exclude = [
    'sites',
];

$finder = Finder::create()->in(__DIR__)->exclude($exclude);
return Config::create()->setRules($rules)->setFinder($finder);
