<?php

use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/controllers',
        __DIR__ . '/config',
        __DIR__ . '/ps_eventbus.php',
    ])

    ->withSets([
        LevelSetList::UP_TO_PHP_56,
        SetList::CODE_QUALITY,
    ])

    ->withRules([
        TypedPropertyFromStrictConstructorRector::class,
    ])

    ->withSkip([
        StringClassNameToClassConstantRector::class,
        SimplifyIfElseToTernaryRector::class
    ]);
