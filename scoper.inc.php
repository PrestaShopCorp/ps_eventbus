<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

$version = preg_replace('/\-/', '_', $_SERVER['VERSION']);
$version = preg_replace('/\./', '_', $version);

return [
    'prefix' => $version,
    'output-dir' => null,
    'finders' => [
        Finder::create()
            ->files()
            ->in($_SERVER['TMP_FOLDER']),
    ],
    'patchers' => [
        static function (string $filePath, string $prefix, string $contents): string {
            if (strpos($filePath, '/vendor/sentry/sentry/lib/Raven/Client.php')) {
                return str_replace(
                    'Raven_Processor_SanitizeDataProcessor',
                    "{$prefix}\\Raven_Processor_SanitizeDataProcessor",
                    $contents
                );
            }

            if (strpos($filePath, 'vendor/segmentio/analytics-php/lib/Segment/Client.php')) {
                return str_replace(
                    '$consumers = array("socket" => "Segment_Consumer_Socket", "file" => "Segment_Consumer_File", "fork_curl" => "Segment_Consumer_ForkCurl");',
                    "\$consumers = array(\"socket\" => \"{$prefix}\\Segment_Consumer_Socket\", \"file\" => \"Segment_Consumer_File\", \"fork_curl\" => \"Segment_Consumer_ForkCurl\");",
                    $contents
                );
            }

            /* Exclude  ps_eventbus class for namspacing */
            if (strpos($filePath, '/ps_eventbus.php')) {
                $newContent = str_replace(
                    "namespace {$prefix};",
                    '',
                    $contents
                );

                return str_replace(
                    "\\class_alias('{$prefix}\\\\Ps_eventbus', 'Ps_eventbus', \\false);",
                    '',
                    $newContent
                );
            }

            /* Exclude upgrade folder for namespacing */
            if (strpos($filePath, '/upgrade') && strpos($filePath, '/vendor') === false) {
                return str_replace(
                    "namespace {$prefix};",
                    '',
                    $contents
                );
            }

            /* Exclude front controller folder for namespacing */
            if (strpos($filePath, '/controllers') && strpos($filePath, '/vendor') === false) {
                return str_replace(
                    "namespace {$prefix};",
                    '',
                    $contents
                );
            }

            return $contents;
        },
    ],
    'exclude-files' => [],
    'exclude-namespaces' => [
        '~^PrestaShop\\\\Module\\\\PsAccounts~',
        '~^PrestaShop\\\\Module\\\\PsEventbus~',
        '~^PrestaShop\\\\PrestaShop~',
        '~^Http\\\\Client~',
        '~^PrestaShopBundle~',
        '~^Symfony~',
        '~^GuzzleHttp~',
        '~^Psr~',
    ],
    'exclude-classes' => [
        '\Ps_eventbus',
        '\Ps_accounts',
        '\Address',
        '\Tax',
        '\Cache',
        '\Configuration',
        '\Combination',
        '\Customization',
        '\TaxManagerFactory',
        '\Context',
        '\Country',
        '\Currency',
        '\RangePrice',
        '\RangeWeight',
        '\Carrier',
        '\Db',
        '\DbQuery',
        '\Employee',
        '\Hook',
        '\Language',
        '\Link',
        '\Media',
        '\Module',
        '\ModuleCore',
        '\ModuleFrontController',
        '\PrestaShopException',
        '\PrestaShopDatabaseException',
        '\Tab',
        '\Tools',
        '\Shop',
        '\Product',
        '\DateTime',
        '\DateTimeZone',
        '\Validate',
        '\Group',
        '\GroupReduction',
        '\SpecificPrice'
    ],
    'exclude-functions' => [],
    'exclude-constants' => [],
    'expose-global-constants' => true,
    'expose-global-classes' => false,
    'expose-global-functions' => true,
    'expose-namespaces' => [],
    'expose-classes' => [
        '\Ps_eventbus',
    ],
    'expose-functions' => [],
    'expose-constants' => [],
];
