<?php

define('ACCESS', true);
define('ROOT_PATH', dirname(__DIR__) . '/');

$composerAutoload = ROOT_PATH . 'vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require $composerAutoload;
}

require ROOT_PATH . 'core/App.php';
