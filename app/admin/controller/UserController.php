<?php

namespace admin\controller;

use core\Security;

class UserController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('UserAccount');
        $this->assign("tableData", "");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrf();
        }

        $page = (int)($_REQUEST['page'] ?? 1);
        $perPage = 15;
        $userModel = new \models\UserModel();
        $users = $userModel->getUserList($page, $perPage);
        $total = $userModel->getUserCount();
        $totalPages = max(1, ceil($total / $perPage));

        $this->assign("users", $users ?: []);
        $this->assign("total", $total);
        $this->assign("page", $page);
        $this->assign("perPage", $perPage);
        $this->assign("totalPages", $totalPages);
        $this->assign("prevPage", max(1, $page - 1));
        $this->assign("nextPage", min($totalPages, $page + 1));

        $this->display("user.php");
    }

    public function add()
    {
        $this->assignCommon();
        $this->setActiveSidebar('UserAccount');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCsrfToken($token)) {
                $this->assign('error', '安全令牌验证失败，请刷新页面重试');
                $this->display("user.php");
                return;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $isAdmin = (int)($_POST['is_admin'] ?? 0);

            if (empty($username) || empty($password)) {
                $this->assign('error', '用户名和密码不能为空');
                $this->display("user.php");
                return;
            }

            $userModel = new \models\UserModel();
            if ($userModel->exists($username)) {
                $this->assign('error', '用户名已存在');
                $this->display("user.php");
                return;
            }

            $result = $userModel->register($username, $password, $isAdmin);
            if ($result) {
                Security::generateCsrfToken();
                $_SESSION['success_msg'] = '用户添加成功';
                header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
                exit;
            } else {
                $this->assign('error', '添加失败，请重试');
                $this->display("user.php");
            }
            return;
        }

        $this->assign("editMode", false);
        $this->display("user.php");
    }

    public function edit()
    {
        $this->assignCommon();
        $this->setActiveSidebar('UserAccount');

        $id = (int)($_REQUEST['id'] ?? 0);
        $userModel = new \models\UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCsrfToken($token)) {
                $this->assign('error', '安全令牌验证失败，请刷新页面重试');
                $this->assign("editMode", true);
                $this->assign("editUser", $userModel->getUserById($id));
                $this->display("user.php");
                return;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $isAdmin = (int)($_POST['is_admin'] ?? 0);

            if (empty($username)) {
                $this->assign('error', '用户名不能为空');
                $this->assign("editMode", true);
                $this->assign("editUser", $userModel->getUserById($id));
                $this->display("user.php");
                return;
            }

            $result = $userModel->updateUser($id, $username, $password, $isAdmin);
            if ($result) {
                Security::generateCsrfToken();
                $_SESSION['success_msg'] = '用户更新成功';
                header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
                exit;
            } else {
                $this->assign('error', '更新失败，请重试');
                $this->assign("editMode", true);
                $this->assign("editUser", $userModel->getUserById($id));
                $this->display("user.php");
            }
            return;
        }

        $user = $userModel->getUserById($id);
        if (!$user) {
            $_SESSION['error_msg'] = '用户不存在';
            header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
            exit;
        }

        $this->assign("editMode", true);
        $this->assign("editUser", $user);
        $this->display("user.php");
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
            exit;
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCsrfToken($token)) {
            $_SESSION['error_msg'] = '安全令牌验证失败';
            header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_msg'] = '无效的用户ID';
            header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
            exit;
        }

        if ($id === (int)($_SESSION['user_id'] ?? 0)) {
            $_SESSION['error_msg'] = '不能删除自己';
            header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
            exit;
        }

        $userModel = new \models\UserModel();
        $result = $userModel->deleteUser($id);
        if ($result) {
            Security::generateCsrfToken();
            $_SESSION['success_msg'] = '用户已删除';
        } else {
            $_SESSION['error_msg'] = '删除失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=User&a=index');
        exit;
    }
}
