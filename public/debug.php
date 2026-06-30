<?php
header('Content-Type: text/plain');
echo "error_reporting: " . error_reporting() . "\n";
echo "E_DEPRECATED: " . E_DEPRECATED . "\n";
echo "E_ALL: " . E_ALL . "\n";
echo "APP_DEBUG: " . (defined('APP_DEBUG') ? (APP_DEBUG ? 'true' : 'false') : 'undefined') . "\n";
echo "getenv APP_DEBUG: " . var_export(getenv('APP_DEBUG'), true) . "\n";

try {
    $obj = new stdClass();
    $obj->test = 'test';
    echo "dynamic property: OK\n";
} catch (\Throwable $e) {
    echo "dynamic property error: " . $e->getMessage() . "\n";
}
