<?php
/* this file exits on /tests/unit too. not sure that we need two files like this (doesn't cause damage if code is commented) */
$prestashopDir = getenv('_PS_ROOT_DIR_');
$projectDir = __DIR__ . '/../..';

require_once $prestashopDir . '/config/config.inc.php';
require_once $projectDir . '/vendor/autoload.php';
