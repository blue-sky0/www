<?php

namespace models;

use core\Model;

class UserModel extends Model
{
    protected $table = 'user';

    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE username = ? LIMIT 1";
        $user = $this->prepare($sql, [$username]);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    public function register($username, $password, $isAdmin = 0)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO {$this->getTable()} (username, password, reg_time, is_admin) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [$username, $hash, time(), $isAdmin]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = ? LIMIT 1";
        return $this->prepare($sql, [$id]);
    }

    public function getUserById($id)
    {
        return $this->getById($id);
    }

    public function exists($username)
    {
        $sql = "SELECT id FROM {$this->getTable()} WHERE username = ? LIMIT 1";
        return (bool)$this->prepare($sql, [$username]);
    }

    public function getUserList($page = 1, $perPage = 15)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT id, username, is_admin, reg_time, created_at FROM {$this->getTable()} ORDER BY id ASC LIMIT ?, ?";
        return $this->prepare($sql, [(int)$offset, (int)$perPage], true);
    }

    public function getUserCount()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->getTable()}";
        $result = $this->query($sql);
        return $result ? (int)$result['total'] : 0;
    }

    public function updateUser($id, $username, $password = '', $isAdmin = 0)
    {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE {$this->getTable()} SET username = ?, password = ?, is_admin = ? WHERE id = ?";
            return $this->execute($sql, [$username, $hash, (int)$isAdmin, (int)$id]);
        } else {
            $sql = "UPDATE {$this->getTable()} SET username = ?, is_admin = ? WHERE id = ?";
            return $this->execute($sql, [$username, (int)$isAdmin, (int)$id]);
        }
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE id = ?";
        return $this->execute($sql, [(int)$id]);
    }
}
