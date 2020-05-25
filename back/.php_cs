<?php
$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/']);
return PhpCsFixer\Config::create()
    ->setRules(
        [
            '@Symfony' => true,
            '@Symfony:risky' => true,
            'align_multiline_comment' => true,
            'array_syntax' => ['syntax' => 'short'],
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'general_phpdoc_annotation_remove' => true,
            'heredoc_to_nowdoc' => true,
            'linebreak_after_opening_tag' => true,
            'list_syntax' => ['syntax' => 'short'],
            'mb_str_functions' => true,
            'modernize_types_casting' => true,
            'native_function_invocation' => true,
            'no_extra_consecutive_blank_lines' => [
                'break',
                'continue',
                'extra',
                'return',
                'throw',
                'use',
                'parenthesis_brace_block',
                'square_brace_block',
                'curly_brace_block',
            ],
            'no_null_property_initialization' => true,
            'no_php4_constructor' => true,
            'no_short_echo_tag' => true,
            'no_superfluous_elseif' => true,
            'no_unreachable_default_argument_value' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'simplified_null_return' => false,
            'ordered_class_elements' => true,
            'ordered_imports' => true,
            'php_unit_strict' => false,
            'phpdoc_add_missing_param_annotation' => true,
            'phpdoc_order' => true,
            'phpdoc_types_order' => true,
            'protected_to_private' => true,
            'psr4' => true,
            'single_line_comment_style' => false,
            'strict_comparison' => true,
            'strict_param' => true,
            'yoda_style' => true,
            'declare_strict_types' => false,
            'single_trait_insert_per_statement' => false
        ]
    )
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setUsingCache(true)
    ->setFinder($finder);
