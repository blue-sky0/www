<?php

namespace admin\controller;

use core\Controller;
use core\Security;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $csrf_token = Security::getCsrfToken();
        $this->assign('csrf_token', $csrf_token);
        $this->assign('error', '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCsrfToken($token)) {
                $this->assign('error', '安全令牌验证失败，请刷新页面重试');
                $this->display('login.php');
                return;
            }

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $this->assign('error', '请输入用户名和密码');
                $this->display('login.php');
                return;
            }

            $userModel = new \models\UserModel();
            $user = $userModel->authenticate($username, $password);

            if (!$user) {
                $this->assign('error', '用户名或密码错误');
                $this->display('login.php');
                return;
            }

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['login_time'] = time();

            try {
                $onlineService = \admin\service\OnlineUserService::getInstance();
                $onlineService->trackActivity('admin', $user['id'], $user['username']);
            } catch (\Exception $e) {
                error_log('login tracking error: ' . $e->getMessage());
            }

            Security::generateCsrfToken();
            header('Location: ' . URL . 'index.php?p=admin');
            exit;
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: ' . URL . 'index.php?p=admin');
            exit;
        }

        $this->display('login.php');
    }

    public function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();

        header('Location: ' . URL . 'index.php?p=admin&c=Auth&a=login');
        exit;
    }
}
