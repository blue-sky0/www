<?php

namespace admin\controller;

use core\Security;

class IndexController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Index');

        $this->assign('success_msg', $_SESSION['success_msg'] ?? '');
        $this->assign('error_msg', $_SESSION['error_msg'] ?? '');
        unset($_SESSION['success_msg'], $_SESSION['error_msg']);

        $this->display('index.php');
    }

    public function dashboard()
    {
        header('Content-Type: application/json; charset=utf-8');

        $statsModel = new \admin\model\StatsModel();
        $logModel = new \admin\model\OperationLogModel();
        $onlineModel = new \admin\model\OnlineUserModel();

        $userStats = $statsModel->getUserStats();

        $data = [
            'user_total'       => $userStats['total_users'],
            'user_admin'       => $userStats['admin_users'],
            'content_count'    => $statsModel->getContentCount(),
            'image_count'      => $statsModel->getImageCount(),
            'video_count'      => $statsModel->getVideoCount(),
            'storage_size'     => $statsModel->getStorageSize(),

            'reg_trend'        => $statsModel->getRegistrationTrend(7),
            'content_category' => $statsModel->getContentCategoryStats(),
            'log_stats'        => $statsModel->getRecentLogStats(7),
            'module_stats'     => $statsModel->getLogModuleStats(),

            'recent_logs'      => $logModel->getRecent(10),

            'php_version'      => phpversion(),
            'mysql_version'    => $this->getMysqlVersion(),
            'server_ip'        => $_SERVER['SERVER_ADDR'] ?? 'unknown',
            'online_users'     => $onlineModel->countOnline(),
            'db_size'          => $statsModel->getDatabaseSize(),
            'cache_status'     => $this->getCacheStatus(),
            'last_backup'      => $this->getLastBackupTime(),
            'system_uptime'    => $this->getSystemUptime(),
            'today_new_users'  => $statsModel->getTodayNewUsers(),
            'today_operations' => $statsModel->getTodayOperations(),
        ];

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    private function getMysqlVersion()
    {
        $statsModel = new \admin\model\StatsModel();
        return $statsModel->getMysqlVersion();
    }

    private function getCacheStatus()
    {
        if (function_exists('opcache_get_status')) {
            $status = opcache_get_status(false);
            return ($status && !empty($status['opcache_enabled'])) ? '已启用' : '未启用';
        }
        return '不支持';
    }

    private function getSystemUptime()
    {
        if (@file_exists('/proc/uptime')) {
            $uptime = @file_get_contents('/proc/uptime');
            if ($uptime !== false) {
                $seconds = (int)explode(' ', $uptime)[0];
                $days = floor($seconds / 86400);
                $hours = floor(($seconds % 86400) / 3600);
                $minutes = floor(($seconds % 3600) / 60);
                return "{$days}天{$hours}小时{$minutes}分钟";
            }
        }
        return '未知';
    }

    private function getLastBackupTime()
    {
        $settings = new \admin\model\SettingsModel();
        $group = $settings->getGroup('system');
        return $group['last_backup_time'] ?? '从未备份';
    }
}
