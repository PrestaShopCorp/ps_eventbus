<?php
/**
 * Bootstrap for unit tests.
 *
 * Most module classes guard themselves with `if (!defined('_PS_VERSION_')) { exit; }`.
 * Autoloading any of them outside of a PrestaShop request would therefore kill
 * the PHPUnit process silently — no failure, no test, exit code 0. Defining the
 * constant up front lets the test suite load them like PrestaShop would.
 */
if (!defined('_PS_VERSION_')) {
    define('_PS_VERSION_', getenv('PS_VERSION') ?: '8.1.6');
}

require_once __DIR__ . '/../vendor/autoload.php';
