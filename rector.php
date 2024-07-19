<?php

declare(strict_types=1);

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
        SetList::NAMING,
        SetList::TYPE_DECLARATION,
        
    ])
    
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class
    ])

    ->withSkip([
        StringClassNameToClassConstantRector::class
    ]);
