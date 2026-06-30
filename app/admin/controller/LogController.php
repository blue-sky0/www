<?php

namespace admin\controller;

class LogController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Log');

        $page = max(1, intval($_GET['page'] ?? 1));
        $pageSize = 30;

        $filters = [
            'module' => $_GET['module'] ?? '',
            'username' => $_GET['username'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $model = new \admin\model\OperationLogModel();
        $result = $model->getLogs($page, $pageSize, $filters);
        $totalPages = max(1, ceil($result['total'] / $pageSize));
        $modules = $model->getDistinctModules();

        $this->assign('logs', $result['rows']);
        $this->assign('total', $result['total']);
        $this->assign('page', $page);
        $this->assign('totalPages', $totalPages);
        $this->assign('perPage', $pageSize);
        $this->assign('prevPage', max(1, $page - 1));
        $this->assign('nextPage', min($totalPages, $page + 1));
        $this->assign('filters', $filters);
        $this->assign('modules', $modules);
        $this->assign("tableData", "");

        $this->display("logs.php");
    }

    public function clean()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Log');
            exit;
        }
        $this->checkCsrf();

        $keepDays = max(30, min(365, intval($_POST['keep_days'] ?? 90)));

        $model = new \admin\model\OperationLogModel();
        $deleted = $model->cleanOldLogs($keepDays);

        $_SESSION['success_msg'] = "已清理 {$deleted} 条旧日志";
        $this->logOperation('log', 'clean', '清理' . $keepDays . '天前的日志，共' . $deleted . '条');

        header('Location: ' . URL . 'index.php?p=admin&c=Log');
        exit;
    }

    public function export()
    {
        $filters = [
            'module' => $_GET['module'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
        ];

        $model = new \admin\model\OperationLogModel();
        $logs = $model->getAllLogs($filters);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="operation_logs_' . date('Ymd_His') . '.csv"');

        echo chr(0xEF) . chr(0xBB) . chr(0xBF);
        echo "ID,用户,模块,操作,IP,时间,状态\n";

        foreach ($logs as $log) {
            echo '"' . $log['id'] . '","' .
                ($log['username'] ?? '-') . '","' .
                ($log['module'] ?? '-') . '","' .
                $log['action'] . '","' .
                ($log['ip_address'] ?? '-') . '","' .
                $log['created_at'] . '","' .
                ($log['status'] ? '成功' : '失败') . "\"\n";
        }
        exit;
    }
}
