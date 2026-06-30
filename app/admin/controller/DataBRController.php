<?php

namespace admin\controller;

use admin\service\BackupService;
use core\Security;

class DataBRController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('DataBR');
        $this->assign("tableData", "");

        $service = new BackupService();
        $backups = $service->getBackupList();

        $this->assign('backups', $backups);
        $this->assign('backupService', $service);

        $this->display("backup.php");
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
            exit;
        }
        $this->checkCsrf();

        $note = trim($_POST['note'] ?? '');
        $service = new BackupService();
        $result = $service->createBackup($note);

        Security::generateCsrfToken();

        if ($result['success']) {
            $_SESSION['success_msg'] = "备份创建成功：{$result['file']} ({$service->formatSize($result['size'])})";
            $this->logOperation('backup', 'create', "创建数据库备份: {$result['file']}");
        } else {
            $_SESSION['error_msg'] = '备份失败：' . ($result['error'] ?? '未知错误');
            $this->logOperation('backup', 'create', '备份失败: ' . ($result['error'] ?? ''), null, null, 0);
        }

        header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
        exit;
    }

    public function restore()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
            exit;
        }
        $this->checkCsrf();

        $filename = $_POST['filename'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if ($confirm !== 'CONFIRM_RESTORE') {
            $_SESSION['error_msg'] = '请输入 CONFIRM_RESTORE 以确认恢复';
            header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
            exit;
        }

        $service = new BackupService();
        $result = $service->restoreBackup($filename);

        Security::generateCsrfToken();

        if ($result['success']) {
            $_SESSION['success_msg'] = '数据库恢复成功';
            $this->logOperation('backup', 'restore', "恢复数据库: {$filename}");
        } else {
            $_SESSION['error_msg'] = '恢复失败：' . ($result['error'] ?? '未知错误');
            $this->logOperation('backup', 'restore', "恢复失败: {$filename}");
        }

        header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
            exit;
        }
        $this->checkCsrf();

        $filename = $_POST['filename'] ?? '';
        $service = new BackupService();

        if ($service->deleteBackup($filename)) {
            $_SESSION['success_msg'] = '备份已删除';
            $this->logOperation('backup', 'delete', "删除备份: {$filename}");
        } else {
            $_SESSION['error_msg'] = '删除失败';
        }

        Security::generateCsrfToken();
        header('Location: ' . URL . 'index.php?p=admin&c=DataBR');
        exit;
    }

    public function download()
    {
        $filename = $_GET['file'] ?? '';
        $service = new BackupService();
        $service->downloadBackup($filename);
    }
}
