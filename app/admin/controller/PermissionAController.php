<?php

namespace admin\controller;

use admin\service\AuthService;

class PermissionAController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('PermissionA');
        $this->assign("tableData", "");

        $roleModel = new \admin\model\RoleModel();
        $userModel = new \models\UserModel();

        $page = (int)($_REQUEST['page'] ?? 1);
        $perPage = 15;
        $users = $userModel->getUserList($page, $perPage);
        $total = $userModel->getUserCount();
        $totalPages = max(1, ceil($total / $perPage));

        $roles = $roleModel->getAllRoles();

        $userRoles = [];
        foreach ($users as $user) {
            $userRoles[$user['id']] = $roleModel->getUserRoles($user['id']);
        }

        $this->assign('users', $users ?: []);
        $this->assign('total', $total);
        $this->assign('page', $page);
        $this->assign('perPage', $perPage);
        $this->assign('totalPages', $totalPages);
        $this->assign('prevPage', max(1, $page - 1));
        $this->assign('nextPage', min($totalPages, $page + 1));
        $this->assign('roles', $roles ?: []);
        $this->assign('userRoles', $userRoles);

        $this->display("permission.php");
    }

    public function assignRole()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=PermissionA');
            exit;
        }
        $this->checkCsrf();

        $adminId = (int)($_POST['admin_id'] ?? 0);
        $roleIds = $_POST['role_ids'] ?? [];

        if ($adminId <= 0) {
            $_SESSION['error_msg'] = '无效的管理员ID';
            header('Location: ' . URL . 'index.php?p=admin&c=PermissionA');
            exit;
        }

        $roleIds = array_map('intval', $roleIds);
        $roleIds = array_filter($roleIds, function($id) { return $id > 0; });

        $roleModel = new \admin\model\RoleModel();
        $roleModel->setUserRoles($adminId, $roleIds);
        AuthService::clearCache($adminId);

        $userModel = new \models\UserModel();
        $user = $userModel->getUserById($adminId);
        $username = $user ? $user['username'] : '#' . $adminId;

        $_SESSION['success_msg'] = "用户 {$username} 的角色已更新";
        $this->logOperation('permission', 'assign_role', "分配角色给 {$username}", 'user', $adminId);

        header('Location: ' . URL . 'index.php?p=admin&c=PermissionA');
        exit;
    }
}
