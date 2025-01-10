<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('translations')
    ->exclude('prestashop')
    ->exclude('dist')
    ->exclude('tools')
    ->exclude('vendor');

$config = (new PrestaShop\CodingStandards\CsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setUsingCache(false)
    ->setFinder($finder);

return $config;
