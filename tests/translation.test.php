<?php

global $BASE_EN_MODULE;
$BASE_EN_MODULE = [];
include 'translations/en.php';
$BASE_EN_MODULE = $_MODULE;
$error = false;
foreach (glob('ranslations/*.php') as $filename) {
    $_MODULE = [];
    include $filename;

    foreach ($BASE_EN_MODULE as $key => $value) {
        if (!array_key_exists($key, $_MODULE)) {
            echo str_replace('<{ps_eventbus}prestashop>ps_eventbus_', '', $key) . ' is missing in ' . $filename . PHP_EOL;
            $error = true;
        }
    }
}
if ($error) {
    echo "Translation checked with errors.\n";
    exit(1);
} else {
    echo "Translation checked without errors.\n";
    exit(0);
}
