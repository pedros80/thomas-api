<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([__DIR__])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCSIgnored(true)
    ->ignoreVCS(true);

$config = new Config();

return $config->setRules([
    '@PSR2'                       => true,
    'array_syntax'                => ['syntax' => 'short'],
    'ordered_imports'             => ['sort_algorithm' => 'alpha'],
    'single_line_after_imports'   => true,
    'trailing_comma_in_multiline' => [],
    'phpdoc_scalar'               => true,
    'unary_operator_spaces'       => true,
    'binary_operator_spaces'      => [
        'operators' => [
            '='  => 'align',
            '=>' => 'align',
        ],
    ],
    'not_operator_with_space'           => false,
    'not_operator_with_successor_space' => false,
    'blank_line_before_statement'       => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try'
        ],
    ],
    'phpdoc_single_line_var_spacing'  => true,
    'whitespace_after_comma_in_array' => true,
    'phpdoc_var_without_name'         => true,
    'method_argument_space'           => [
        'on_multiline'                     => 'ensure_fully_multiline',
        'keep_multiple_spaces_after_comma' => true,
    ],
    'blank_line_after_namespace'   => true,
    'blank_line_after_opening_tag' => true,
    'constant_case'                => [
        'case' => 'lower'
    ],
])->setFinder($finder);
