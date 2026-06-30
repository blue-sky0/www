<?php

namespace admin\controller;

use admin\service\CacheService;
use core\Security;

class CacheController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Cache');
        $this->assign("tableData", "");

        $service = new CacheService();
        $stats = $service->getStats();
        $recommendations = $service->getRecommendations();

        $this->assign('stats', $stats);
        $this->assign('recommendations', $recommendations);
        $this->assign('TYPES', CacheService::TYPES);

        $this->display("cache.php");
    }

    public function clear()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=Cache');
            exit;
        }
        $this->checkCsrf();

        $type = $_POST['type'] ?? 'all';
        $service = new CacheService();

        if ($type === 'all') {
            $result = $service->clearAll();
        } elseif ($type === 'expired') {
            $result = $service->clearExpired();
        } else {
            $result = $service->clearType($type);
        }

        Security::generateCsrfToken();

        if ($result['success']) {
            $_SESSION['success_msg'] = $result['message'];
            $this->logOperation('cache', 'clear', "清理缓存: {$type}, 文件数: {$result['count']}");
        } else {
            $_SESSION['error_msg'] = $result['error'] ?? '清理失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Cache');
        exit;
    }
}
