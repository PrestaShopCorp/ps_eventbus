<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('translations')
    ->exclude('prestashop')
    ->exclude('dist')
    ->exclude('tools')
    ->exclude('vendor');

$config = (new PrestaShop\CodingStandards\CsFixer\Config())
    ->setUsingCache(false)
    ->setFinder($finder)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

return $config;
