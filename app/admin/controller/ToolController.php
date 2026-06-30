<?php

namespace admin\controller;

use admin\service\OptimizationService;
use admin\service\PerformanceService;
use core\Security;

class ToolController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Tool');
        $this->assign("tableData", "");

        $perf = new PerformanceService();
        $system = $perf->getSystemLoad();
        $scoreInfo = $perf->getPerformanceScore();
        $responseTimes = $perf->getResponseTimes(7);
        $optimizationTips = $perf->getPhpOptimizationTips();

        $dbStatus = $perf->getDatabaseStatus();
        $slowQueries = $perf->getSlowQueries(10);
        $errors = $perf->getRecentErrors(20);

        $opt = new OptimizationService();
        $tables = $opt->getTableStatus();

        $rtLabels = json_encode(array_column($responseTimes, 'date'));
        $rtAvg = json_encode(array_column($responseTimes, 'avg'));
        $rtMax = json_encode(array_column($responseTimes, 'max'));

        $this->assign('system', $system);
        $this->assign('scoreInfo', $scoreInfo);
        $this->assign('rtLabels', $rtLabels);
        $this->assign('rtAvg', $rtAvg);
        $this->assign('rtMax', $rtMax);
        $this->assign('dbStatus', $dbStatus);
        $this->assign('slowQueries', $slowQueries);
        $this->assign('errors', $errors);
        $this->assign('optimizationTips', $optimizationTips);
        $this->assign('tables', $tables);

        $this->display("tool.php");
    }

    public function optimize()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=Tool');
            exit;
        }
        $this->checkCsrf();

        $service = new OptimizationService();
        $result = $service->optimizeAllTables();

        Security::generateCsrfToken();

        if ($result['success']) {
            $total = count($result['results']);
            $_SESSION['success_msg'] = "优化完成: {$total} 张表";
            $this->logOperation('optimize', 'all', "优化 {$total} 张数据表");
        } else {
            $_SESSION['error_msg'] = $result['error'] ?? '优化失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Tool');
        exit;
    }

    public function clearPhpCache()
    {
        if (function_exists('opcache_reset')) {
            opcache_reset();
            $_SESSION['success_msg'] = 'OPcache 已重置';
            $this->logOperation('optimize', 'opcache_reset', '重置 OPCache');
        } else {
            $_SESSION['error_msg'] = 'OPCache 未启用';
        }
        Security::generateCsrfToken();
        header('Location: ' . URL . 'index.php?p=admin&c=Tool');
        exit;
    }
}
