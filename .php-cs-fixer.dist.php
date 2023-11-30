<?php

$config = new PrestaShop\CodingStandards\CsFixer\Config();

$config
    ->setUsingCache(true)
    ->getFinder()
    ->in(__DIR__)
    ->exclude('translations')
    ->exclude('prestashop')
    ->exclude('vendor');

return $config;