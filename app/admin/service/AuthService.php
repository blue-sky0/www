<?php

namespace admin\service;

use admin\constants\Permissions;

class AuthService
{
    private static $permissionCache = [];

    public static function hasPermission($adminId, $permission)
    {
        if (!isset(self::$permissionCache[$adminId])) {
            self::loadPermissions($adminId);
        }
        $perms = self::$permissionCache[$adminId];
        if (in_array(Permissions::PERMISSION_ALL, $perms)) {
            return true;
        }
        return in_array($permission, $perms);
    }

    public static function hasAnyPermission($adminId, array $permissions)
    {
        foreach ($permissions as $perm) {
            if (self::hasPermission($adminId, $perm)) {
                return true;
            }
        }
        return false;
    }

    public static function requirePermission($permission)
    {
        $adminId = (int)($_SESSION['user_id'] ?? 0);
        if ($adminId <= 0) {
            header('Location: ' . URL . 'index.php?p=admin&c=Auth&a=login');
            exit;
        }
        if (self::hasPermission($adminId, $permission)) {
            return true;
        }
        $_SESSION['error_msg'] = '权限不足，无法执行此操作';
        if (!headers_sent()) {
            $referer = $_SERVER['HTTP_REFERER'] ?? (URL . 'index.php?p=admin');
            header('Location: ' . $referer);
            exit;
        }
        exit;
    }

    public static function getUserPermissions($adminId)
    {
        if (!isset(self::$permissionCache[$adminId])) {
            self::loadPermissions($adminId);
        }
        return self::$permissionCache[$adminId];
    }

    public static function getUserRoles($adminId)
    {
        $model = new \admin\model\RoleModel();
        return $model->getUserRoles($adminId);
    }

    public static function clearCache($adminId = null)
    {
        if ($adminId) {
            unset(self::$permissionCache[$adminId]);
        } else {
            self::$permissionCache = [];
        }
    }

    private static function loadPermissions($adminId)
    {
        $model = new \admin\model\RoleModel();
        $roles = $model->getUserRoles($adminId);
        $permissions = [];

        foreach ($roles as $role) {
            $rolePerms = $model->getRolePermissions($role['id']);
            foreach ($rolePerms as $p) {
                $permissions[$p['permission']] = true;
            }
        }

        if (isset($permissions[Permissions::PERMISSION_ALL])) {
            self::$permissionCache[$adminId] = [Permissions::PERMISSION_ALL];
        } else {
            self::$permissionCache[$adminId] = array_keys($permissions);
        }
    }
}
