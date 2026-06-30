<?php

namespace admin\controller;

use core\Controller;
use core\Security;
use admin\model\OperationLogModel;
use admin\service\OnlineUserService;

/**
 * 后台控制器基类
 *
 * 所有后台控制器均继承此类，提供：
 * - CSRF Token 初始化与验证
 * - 登录状态检查（自动跳转登录页）
 * - 侧边栏/导航栏数据加载
 * - 通用模板变量分配
 * - 权限检查（requirePermission / hasPermission）
 * - 操作日志记录（logOperation）
 * - 在线用户跟踪（trackOnlineUser）
 * - 侧边栏高亮（setActiveSidebar）
 */
abstract class BaseController extends Controller
{
    /** @var array 主菜单（侧边栏一级） */
    protected $MainTitledata;

    /** @var array 子菜单（侧边栏二级） */
    protected $MinTitledata;

    /** @var array 数据库表名列表 */
    protected $TablesName;

    /** @var string 当前激活的一级菜单名称（用于侧边栏展开高亮） */
    protected $infoMainTitle;

    public function __construct()
    {
        parent::__construct();
        $this->initCsrf();
        $this->checkAuth();
        $this->loadSidebar();
    }

    /**
     * 初始化 CSRF Token（在 Session 中生成）
     */
    protected function initCsrf()
    {
        Security::getCsrfToken();
    }

    /**
     * 验证 POST 请求的 CSRF Token
     *
     * 验证失败时写入 error_msg 并重定向到后台首页。
     * GET 请求跳过验证。
     */
    protected function checkCsrf()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        $token = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCsrfToken($token)) {
            $_SESSION['error_msg'] = '安全令牌验证失败，请刷新页面重试';
            header('Location: ' . URL . 'index.php?p=admin');
            exit;
        }
        Security::generateCsrfToken();
        $this->assign('csrf_token', Security::getCsrfToken());
    }

    /**
     * 检查用户登录状态
     *
     * 未登录时跳转到后台登录页。
     */
    private function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL . 'index.php?p=admin&c=Auth&a=login');
            exit;
        }
    }

    /**
     * 加载侧边栏和导航栏数据
     *
     * 从数据库加载主菜单/子菜单/表名列表。
     */
    protected function loadSidebar()
    {
        $mainTitle = new \admin\model\BackSystemModel();
        $this->MainTitledata = $mainTitle->getBackSystemData();

        $minTitle = new \admin\model\AdminModel();
        $this->MinTitledata = $minTitle->getAdminData();

        $allFunction = new \admin\model\AllFunctionModel();
        $this->TablesName = $allFunction->getLibTablesName();
    }

    /**
     * 给模板分配通用变量
     *
     * 包括：侧边栏数据、用户名、当前控制器、CSRF Token 等。
     * 同时记录当前用户的在线状态。
     */
    protected function assignCommon()
    {
        $this->assign("MainTitledata", $this->MainTitledata);
        $this->assign("MinTitledata", $this->MinTitledata);
        $this->assign("session_username", $_SESSION['username'] ?? '');
        $this->assign("S", S);
        $this->assign("C", C);
        $this->assign("csrf_token", Security::getCsrfToken());

        $this->trackOnlineUser();
    }

    /**
     * 记录当前用户的在线活动
     */
    private function trackOnlineUser()
    {
        try {
            $service = OnlineUserService::getInstance();
            if (!empty($_SESSION['user_id'])) {
                $userType = !empty($_SESSION['is_admin']) ? 'admin' : 'user';
                $service->trackActivity($userType, $_SESSION['user_id'], $_SESSION['username']);
            } else {
                $service->trackActivity('guest');
            }
        } catch (\Exception $e) {
            error_log('trackOnlineUser error: ' . $e->getMessage());
        }
    }

    /**
     * 检查权限，无权限时终止请求
     *
     * @param string $permission 权限标识（如 'user.manage'）
     */
    protected function requirePermission($permission)
    {
        return \admin\service\AuthService::requirePermission($permission);
    }

    /**
     * 检查当前用户是否拥有指定权限
     *
     * @param string $permission 权限标识
     * @return bool
     */
    protected function hasPermission($permission)
    {
        $adminId = (int)($_SESSION['user_id'] ?? 0);
        return \admin\service\AuthService::hasPermission($adminId, $permission);
    }

    /**
     * 设置侧边栏高亮菜单
     *
     * 根据控制器名匹配对应的菜单位置，展开并高亮。
     * $typeMap 定义了控制器名到菜单名的映射关系。
     *
     * @param string $types 当前控制器名
     */
    protected function setActiveSidebar($types)
    {
        $typeMap = [
            'Data' => ['DataIE', 'DataReport'],
            'Settings' => ['Settings', 'EmailSet', 'Third-party'],
            'Log' => ['Log', 'Security'],
            'Role' => ['Role', 'PermissionA'],
            'OnlineUser' => ['OnlineUser'],
            'DataBR' => ['DataBR'],
            'BehaviorAnalysis' => ['BehaviorAnalysis'],
            'AnalysisController' => ['BehaviorAnalysis'],
            'Cache' => ['Cache'],
            'Tool' => ['Tool'],
            'Security' => ['Security'],
        ];

        $matchTypes = $typeMap[$types] ?? [$types];

        foreach ($this->MinTitledata as $item) {
            if (in_array($item['types'], $matchTypes, true)) {
                $this->infoMainTitle = $item['course'];
                break;
            }
        }
        $this->assign("infoMainTitle", $this->infoMainTitle);
    }

    /**
     * 记录操作日志
     *
     * @param string $module     模块名（如 data_ie, auth）
     * @param string $action     操作名（如 export, import, login）
     * @param string|null $detail 操作详情
     * @param string|null $targetType 目标类型
     * @param int|null $targetId 目标 ID
     */
    protected function logOperation($module, $action, $detail = null, $targetType = null, $targetId = null)
    {
        try {
            $data = [
                'admin_id' => (int)($_SESSION['user_id'] ?? 0),
                'username' => $_SESSION['username'] ?? 'unknown',
                'module' => $module,
                'action' => $action,
                'target_type' => $targetType,
                'target_id' => $targetId,
                'detail' => is_string($detail) ? $detail : json_encode($detail, JSON_UNESCAPED_UNICODE),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
                'request_url' => $_SERVER['REQUEST_URI'] ?? '',
                'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
                'status' => 1,
            ];
            $logModel = new OperationLogModel();
            $logModel->addLog($data);
        } catch (\Exception $e) {
            error_log('logOperation failed: ' . $e->getMessage());
        }
    }
}
