<?php

namespace admin\model;

use \core\Model;

class RoleModel extends Model
{
    protected $table = 'roles';

    public function getRoleById($id)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = ? LIMIT 1";
        return $this->prepare($sql, [(int)$id]);
    }

    public function getRoleBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE slug = ? LIMIT 1";
        return $this->prepare($sql, [$slug]);
    }

    public function getAllRoles()
    {
        $sql = "SELECT * FROM {$this->getTable()} ORDER BY id ASC";
        return $this->prepare($sql, [], true);
    }

    public function createRole($name, $slug, $description = '', $isSystem = 0)
    {
        $sql = "INSERT INTO {$this->getTable()} (`name`, `slug`, `description`, `is_system`) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [$name, $slug, $description, (int)$isSystem]);
    }

    public function updateRole($id, $name, $description = '')
    {
        $sql = "UPDATE {$this->getTable()} SET `name` = ?, `description` = ? WHERE id = ?";
        return $this->execute($sql, [$name, $description, (int)$id]);
    }

    public function deleteRole($id)
    {
        $role = $this->getRoleById($id);
        if ($role && $role['is_system']) {
            return false;
        }
        $this->execute("DELETE FROM {$this->getTable()} WHERE id = ?", [(int)$id]);
        $this->execute("DELETE FROM S_role_permissions WHERE role_id = ?", [(int)$id]);
        $this->execute("DELETE FROM S_admin_role WHERE role_id = ?", [(int)$id]);
        return true;
    }

    public function getRolePermissions($roleId)
    {
        $sql = "SELECT * FROM S_role_permissions WHERE role_id = ?";
        return $this->prepare($sql, [(int)$roleId], true);
    }

    public function setRolePermissions($roleId, array $permissions)
    {
        $this->execute("DELETE FROM S_role_permissions WHERE role_id = ?", [(int)$roleId]);
        foreach ($permissions as $perm) {
            $this->execute(
                "INSERT INTO S_role_permissions (role_id, permission) VALUES (?, ?)",
                [(int)$roleId, $perm]
            );
        }
        return true;
    }

    public function getUserRoles($adminId)
    {
        $sql = "SELECT r.* FROM {$this->getTable()} r
                INNER JOIN S_admin_role ar ON r.id = ar.role_id
                WHERE ar.admin_id = ?
                ORDER BY r.id ASC";
        return $this->prepare($sql, [(int)$adminId], true);
    }

    public function setUserRoles($adminId, array $roleIds)
    {
        $this->execute("DELETE FROM S_admin_role WHERE admin_id = ?", [(int)$adminId]);
        foreach ($roleIds as $roleId) {
            $this->execute(
                "INSERT INTO S_admin_role (admin_id, role_id) VALUES (?, ?)",
                [(int)$adminId, (int)$roleId]
            );
        }
        return true;
    }

    public function getUsersByRole($roleId)
    {
        $sql = "SELECT u.* FROM S_user u
                INNER JOIN S_admin_role ar ON u.id = ar.admin_id
                WHERE ar.role_id = ?
                ORDER BY u.id ASC";
        return $this->prepare($sql, [(int)$roleId], true);
    }

    public function getAssignableAdmins()
    {
        $sql = "SELECT id, username FROM S_user WHERE is_admin = 1 ORDER BY id ASC";
        return $this->prepare($sql, [], true);
    }
}
