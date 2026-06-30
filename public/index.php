<?php

define('ACCESS', true);

define('ROOT_PATH', str_replace('\\', '/', dirname(__DIR__)) . '/');

// 安全头部
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// 优先加载 Composer 自动加载（如果存在）
$composerAutoload = ROOT_PATH . 'vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require $composerAutoload;
}

require ROOT_PATH . 'core/App.php';

$__appStartTime = microtime(true);

register_shutdown_function(function() use ($__appStartTime) {
    if (session_status() === PHP_SESSION_ACTIVE && !empty($_SERVER['REQUEST_URI'])) {
        // 80% sampling rate
        if (mt_rand(1, 100) <= 80) {
            try {
                $service = \admin\service\AccessLogService::getInstance();
                $service->log($__appStartTime);
            } catch (\Exception $e) {
                error_log('AccessLog shutdown error: ' . $e->getMessage());
            }
        }
    }
});

\core\App::start();
