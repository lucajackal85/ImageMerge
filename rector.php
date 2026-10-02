<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // PHP version taken from composer.json ("php": "^8.2")
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
    )
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withSkip([
        // strict_types would turn float->int coercions inside the library into TypeErrors;
        // enable it once every code path is covered by tests
        SafeDeclareStrictTypesRector::class,
    ]);
