<?php

namespace admin\service;

use admin\model\OnlineUserModel;

class OnlineUserService
{
    const SESSION_TIMEOUT = 1800;

    private static $instance = null;
    private $model;

    private function __construct()
    {
        $this->model = new OnlineUserModel();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function trackActivity($userType, $userId = null, $username = null)
    {
        $sessionId = session_id();
        if (empty($sessionId)) return;

        $data = [
            'session_id'    => $sessionId,
            'user_type'     => $userType,
            'user_id'       => $userId,
            'username'      => $username,
            'ip_address'    => $this->getClientIp(),
            'user_agent'    => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            'last_activity' => date('Y-m-d H:i:s'),
            'login_time'    => date('Y-m-d H:i:s'),
            'current_url'   => substr($_SERVER['REQUEST_URI'] ?? '', 0, 500),
        ];

        $this->model->upsert($data);
    }

    public function getOnlineUsers(array $filters = [], $page = 1, $pageSize = 50)
    {
        return $this->model->getOnlineList($filters, $page, $pageSize);
    }

    public function getOnlineCount($userType = null)
    {
        return $this->model->countOnline($userType);
    }

    public function getOverview()
    {
        return [
            'total_online' => $this->model->countOnline(),
            'admin_online' => $this->model->countOnline('admin'),
            'user_online'  => $this->model->countOnline('user'),
            'guest_online' => $this->model->countGuests(),
            'unique_ips'   => $this->model->countUniqueIps(),
        ];
    }

    public function getSessionInfo($sessionId)
    {
        return $this->model->getBySessionId($sessionId);
    }

    public function kickUser($sessionId, $reason = '管理员强制下线')
    {
        $session = $this->model->getBySessionId($sessionId);
        if (!$session) return false;

        $this->destroySession($sessionId);
        $this->model->recordLogout($session, 'kicked', $reason);
        $this->model->deleteBySessionId($sessionId);

        return true;
    }

    public function kickByIp($ipAddress, $reason = 'IP被封禁')
    {
        $sessions = $this->model->getByIp($ipAddress);
        $count = 0;
        foreach ($sessions as $session) {
            if ($this->kickUser($session['session_id'], $reason)) {
                $count++;
            }
        }
        return $count;
    }

    public function getLoginHistory(array $filters = [], $page = 1, $pageSize = 30)
    {
        return $this->model->getLoginHistory($filters, $page, $pageSize);
    }

    private function destroySession($targetSessionId)
    {
        $sessionPath = session_save_path();
        if (empty($sessionPath)) {
            $sessionPath = sys_get_temp_dir();
        }
        $sessionFile = $sessionPath . '/sess_' . $targetSessionId;
        if (file_exists($sessionFile)) {
            @unlink($sessionFile);
        }
    }

    private function getClientIp()
    {
        $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        foreach ($headers as $h) {
            if (!empty($_SERVER[$h])) {
                $ip = $_SERVER[$h];
                if (strpos($ip, ',') !== false) $ip = trim(explode(',', $ip)[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
            }
        }
        return '127.0.0.1';
    }
}
