<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'whitespace_after_comma_in_array' => true,
        'trailing_comma_in_multiline_array' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'trim_array_spaces' => true,
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'ordered_imports' => ['sort_algorithm' => 'length'],
        'no_unused_imports' => true,
        'blank_line_before_statement' => true,
        'no_extra_blank_lines' => true,
        'single_quote' => true,
        'cast_spaces' => true,
        'trim_array_spaces' => true,
        'single_trait_insert_per_statement' => true,
        'not_operator_with_successor_space' => true,
        'visibility_required' => [
            'property',
            'method',
            'const',
        ],
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder($finder);
