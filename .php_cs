<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PHP70Migration' => true,
    '@PHP70Migration:risky' => true,
    '@PHP71Migration' => true,
    '@PHP71Migration:risky' => true,
    'align_multiline_comment' => true,
    'array_syntax' => ['syntax' => 'short'],
    'blank_line_before_statement' => [],
    'combine_consecutive_unsets' => true,
    'declare_strict_types' => false,
    'is_null' => ['use_yoda_style' => false],
    'no_null_property_initialization' => true,
    'no_short_echo_tag' => true,
    'no_unreachable_default_argument_value' => false,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_order' => true,
    'phpdoc_separation' => false,
    'return_type_declaration' => ['space_before' => 'one'],
    'semicolon_after_instruction' => true,
    'silenced_deprecation_error' => false,
    'strict_comparison' => true,
    'strict_param' => true,
    'yoda_style' => false,
];

$exclude = [
    'sites',
];

$finder = Finder::create()->in(__DIR__)->exclude($exclude);
return Config::create()->setRiskyAllowed(true)->setRules($rules)->setFinder($finder);
