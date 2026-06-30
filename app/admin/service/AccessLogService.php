<?php

namespace admin\service;

use admin\model\AccessLogModel;

class AccessLogService
{
    private static $instance = null;
    private $model;

    private $excludePatterns = [
        '#\.(css|js|png|jpg|jpeg|gif|ico|svg|woff2?)$#i',
        '#/assets/#i',
        '#/public/images/#i',
        '#/heartbeat#i',
        '#/favicon\.ico#i',
    ];

    private function __construct()
    {
        $this->model = new AccessLogModel();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function log($startTime = null)
    {
        $url = $_SERVER['REQUEST_URI'] ?? '';
        foreach ($this->excludePatterns as $pattern) {
            if (preg_match($pattern, $url)) return;
        }

        $userType = 'guest';
        $userId = null;
        $sessionId = session_id() ?: null;

        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            $userType = 'admin';
            $userId = $_SESSION['user_id'] ?? null;
        } elseif (isset($_SESSION['user_id'])) {
            $userType = 'user';
            $userId = $_SESSION['user_id'];
        }

        $data = [
            'user_type'      => $userType,
            'user_id'        => $userId,
            'session_id'     => $sessionId,
            'ip_address'     => $this->getClientIp(),
            'user_agent'     => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            'request_url'    => substr($url, 0, 500),
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'referer_url'    => substr($_SERVER['HTTP_REFERER'] ?? '', 0, 500),
            'page_title'     => $this->extractPageTitle(),
            'response_time'  => $startTime ? (int)((microtime(true) - $startTime) * 1000) : null,
            'response_code'  => http_response_code() ?: 200,
        ];

        try {
            $this->model->insert($data);
        } catch (\Exception $e) {
            error_log('AccessLog error: ' . $e->getMessage());
        }
    }

    public function getAccessTrend($days = 7)
    {
        return $this->model->getDailyTrend($days);
    }

    public function getTopPages($days = 7, $limit = 20)
    {
        return $this->model->getTopPages($days, $limit);
    }

    public function getTopReferrers($days = 7, $limit = 10)
    {
        return $this->model->getTopReferrers($days, $limit);
    }

    public function getUserJourney($sessionId)
    {
        return $this->model->getSessionPages($sessionId);
    }

    public function getRealTimeStats()
    {
        return [
            'last_5min'   => $this->model->countRecent(300),
            'last_1hour'  => $this->model->countRecent(3600),
            'last_24hour' => $this->model->countRecent(86400),
        ];
    }

    public function getAccessList(array $filters = [], $page = 1, $pageSize = 50)
    {
        return $this->model->getAccessList($filters, $page, $pageSize);
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

    private function extractPageTitle()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '';
        $map = [
            'c=Index'   => '后台首页',
            'c=User'    => '用户管理',
            'c=Role'    => '角色管理',
            'c=Article' => '文章管理',
            'c=Image'   => '图片管理',
            'c=Video'   => '视频管理',
            'c=Data'    => '数据管理',
            'c=Settings' => '系统设置',
            'c=Log'     => '日志记录',
        ];
        foreach ($map as $key => $title) {
            if (strpos($url, $key) !== false) return $title;
        }
        return null;
    }
}
