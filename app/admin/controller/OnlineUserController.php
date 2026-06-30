<?php

namespace admin\controller;

use admin\service\OnlineUserService;
use core\Security;

class OnlineUserController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('OnlineUser');
        $this->assign("tableData", "");

        $service = OnlineUserService::getInstance();
        $overview = $service->getOverview();

        $filters = [
            'user_type' => $_GET['user_type'] ?? '',
            'username'  => $_GET['username'] ?? '',
            'ip_address'=> $_GET['ip_address'] ?? '',
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $result = $service->getOnlineUsers($filters, $page);
        $totalPages = max(1, ceil($result['total'] / 50));

        $this->assign('overview', $overview);
        $this->assign('onlineUsers', $result['rows']);
        $this->assign('total', $result['total']);
        $this->assign('page', $page);
        $this->assign('totalPages', $totalPages);
        $this->assign('prevPage', max(1, $page - 1));
        $this->assign('nextPage', min($totalPages, $page + 1));
        $this->assign('filters', $filters);

        $this->display("online_users.php");
    }

    public function kick()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
            exit;
        }
        $this->checkCsrf();

        $sessionId = $_POST['session_id'] ?? '';
        $reason = trim($_POST['reason'] ?? '管理员强制下线');

        $service = OnlineUserService::getInstance();
        if ($service->kickUser($sessionId, $reason)) {
            $_SESSION['success_msg'] = '已踢出该用户';
        } else {
            $_SESSION['error_msg'] = '踢出失败，会话可能已过期';
        }
        Security::generateCsrfToken();
        $this->logOperation('online', 'kick', "踢出用户: {$sessionId}");

        header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
        exit;
    }

    public function kickByIp()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
            exit;
        }
        $this->checkCsrf();

        $ipAddress = $_POST['ip_address'] ?? '';
        $reason = trim($_POST['reason'] ?? 'IP被封禁');

        if (!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            $_SESSION['error_msg'] = '无效的IP地址';
            header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
            exit;
        }

        $service = OnlineUserService::getInstance();
        $count = $service->kickByIp($ipAddress, $reason);

        Security::generateCsrfToken();
        $_SESSION['success_msg'] = "已踢出 {$count} 个来自 {$ipAddress} 的用户";
        $this->logOperation('online', 'kick_ip', "踢出IP: {$ipAddress} ({$count}个会话)");

        header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
        exit;
    }

    public function history()
    {
        $this->assignCommon();
        $this->setActiveSidebar('OnlineUser');

        $filters = [
            'user_type' => $_GET['user_type'] ?? '',
            'username'  => $_GET['username'] ?? '',
            'ip_address'=> $_GET['ip_address'] ?? '',
            'status'    => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to'   => $_GET['date_to'] ?? '',
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $service = OnlineUserService::getInstance();
        $result = $service->getLoginHistory($filters, $page);
        $totalPages = max(1, ceil($result['total'] / 30));

        $this->assign('history', $result['rows']);
        $this->assign('total', $result['total']);
        $this->assign('page', $page);
        $this->assign('totalPages', $totalPages);
        $this->assign('prevPage', max(1, $page - 1));
        $this->assign('nextPage', min($totalPages, $page + 1));
        $this->assign('filters', $filters);

        $this->display("online_history.php");
    }

    public function detail()
    {
        $sessionId = $_GET['session_id'] ?? '';
        $service = OnlineUserService::getInstance();
        $info = $service->getSessionInfo($sessionId);

        if (!$info) {
            $_SESSION['error_msg'] = '会话不存在或已过期';
            header('Location: ' . URL . 'index.php?p=admin&c=OnlineUser');
            exit;
        }

        $this->assignCommon();
        $this->assign('session', $info);
        $this->display("online_detail.php");
    }
}
