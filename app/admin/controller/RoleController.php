<?php

namespace admin\controller;

use admin\constants\Permissions;
use admin\service\AuthService;

class RoleController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Role');
        $this->assign("tableData", "");

        $roleModel = new \admin\model\RoleModel();
        $roles = $roleModel->getAllRoles();
        $this->assign('roles', $roles ?: []);

        $permissions = Permissions::getGrouped();
        $this->assign('permGroups', $permissions);

        $permLabels = [];
        foreach (Permissions::getAll() as $p) {
            $permLabels[$p] = Permissions::getLabel($p);
        }
        $this->assign('permLabels', $permLabels);

        $this->assign('editRole', null);
        $this->assign('editMode', false);

        $this->assign('action', 'role');
        $this->display("role.php");
    }

    public function edit()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Role');

        $id = (int)($_REQUEST['id'] ?? 0);
        $roleModel = new \admin\model\RoleModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrf();

            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $permissions = $_POST['permissions'] ?? [];

            if (empty($name)) {
                $_SESSION['error_msg'] = '角色名称不能为空';
                header('Location: ' . URL . 'index.php?p=admin&c=Role&a=edit&id=' . $id);
                exit;
            }

            $roleModel->updateRole($id, $name, $description);
            $roleModel->setRolePermissions($id, $permissions);

            AuthService::clearCache();

            $_SESSION['success_msg'] = '角色更新成功';
            $this->logOperation('role', 'edit', '编辑角色：' . $name, 'role', $id);

            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $role = $roleModel->getRoleById($id);
        if (!$role) {
            $_SESSION['error_msg'] = '角色不存在';
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $rolePerms = $roleModel->getRolePermissions($id);
        $rolePermList = [];
        foreach ($rolePerms as $rp) {
            $rolePermList[] = $rp['permission'];
        }

        $roles = $roleModel->getAllRoles();
        $this->assign('roles', $roles ?: []);

        $permissions = Permissions::getGrouped();
        $this->assign('permGroups', $permissions);

        $permLabels = [];
        foreach (Permissions::getAll() as $p) {
            $permLabels[$p] = Permissions::getLabel($p);
        }
        $this->assign('permLabels', $permLabels);

        $this->assign('editRole', $role);
        $this->assign('rolePerms', $rolePermList);
        $this->assign('editMode', true);

        $this->assign('action', 'role');
        $this->display("role.php");
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }
        $this->checkCsrf();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $permissions = $_POST['permissions'] ?? [];

        if (empty($name) || empty($slug)) {
            $_SESSION['error_msg'] = '角色名称和标识不能为空';
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $roleModel = new \admin\model\RoleModel();
        $slug = preg_replace('/[^a-zA-Z0-9_]/', '_', $slug);

        if ($roleModel->getRoleBySlug($slug)) {
            $_SESSION['error_msg'] = '角色标识已存在';
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $id = $roleModel->createRole($name, $slug, $description);
        if ($id) {
            $roleModel->setRolePermissions($id, $permissions);
            AuthService::clearCache();
            $_SESSION['success_msg'] = '角色创建成功';
            $this->logOperation('role', 'create', '创建角色：' . $name, 'role', $id);
        } else {
            $_SESSION['error_msg'] = '创建失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Role');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!\core\Security::verifyCsrfToken($token)) {
            $_SESSION['error_msg'] = '安全令牌验证失败';
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }
        \core\Security::generateCsrfToken();

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_msg'] = '无效的角色ID';
            header('Location: ' . URL . 'index.php?p=admin&c=Role');
            exit;
        }

        $roleModel = new \admin\model\RoleModel();
        if ($roleModel->deleteRole($id)) {
            AuthService::clearCache();
            $_SESSION['success_msg'] = '角色已删除';
            $this->logOperation('role', 'delete', '删除角色ID：' . $id, 'role', $id);
        } else {
            $_SESSION['error_msg'] = '系统角色不能删除';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Role');
        exit;
    }
}
