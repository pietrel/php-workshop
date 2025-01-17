<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// Define files and directories to include in the fixing process
$finder = Finder::create()
    ->in(__DIR__) // Search in the current directory
    ->exclude('vendor') // Exclude the "vendor" directory
    ->name('*.php') // Only include PHP files
    ->notName('*.blade.php') // Exclude Blade template files, if any
    ->ignoreDotFiles(true) // Ignore dotfiles
    ->ignoreVCS(true); // Ignore version control system files

// Define the configuration
return (new Config())
    ->setRiskyAllowed(true) // Allow risky rules
    ->setFinder($finder) // Set the finder
    ->setRules([
        '@PSR12' => true, // Enable PSR-12 coding standard
        'array_syntax' => ['syntax' => 'short'], // Use short array syntax
        'no_unused_imports' => true, // Remove unused `use` statements
        'ordered_imports' => ['sort_algorithm' => 'alpha'], // Order `use` statements alphabetically
        'single_quote' => true, // Use single quotes where possible
        'no_trailing_whitespace' => true, // Remove trailing whitespace
        'no_whitespace_in_blank_line' => true, // Remove whitespace in blank lines
        'blank_line_after_namespace' => true, // Ensure blank line after namespace declaration
        'blank_line_after_opening_tag' => true, // Ensure blank line after opening PHP tag
        'align_multiline_comment' => ['comment_type' => 'all_multiline'], // Align multiline comments
        'binary_operator_spaces' => [
            'operators' => ['=>' => 'align_single_space_minimal'],
        ], // Align `=>` operators
        'phpdoc_align' => ['align' => 'vertical'], // Align PHPDoc annotations
        'phpdoc_no_empty_return' => true, // Remove `@return void` if method has no return
        'phpdoc_order' => true, // Order PHPDoc tags (e.g., `@param`, `@return`)
    ]);
