<?php

namespace admin\model;

use \core\Model;

class OnlineUserModel extends Model
{
    protected $table = 'S_online_users';

    public function upsert(array $data)
    {
        $existing = $this->getBySessionId($data['session_id']);
        $loginTime = $data['last_activity'];
        if ($existing && !empty($existing['login_time'])) {
            $loginTime = $existing['login_time'];
        }

        $sql = "INSERT INTO {$this->table} 
                (session_id, user_type, user_id, username, ip_address, user_agent, last_activity, login_time, current_url)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                user_type = VALUES(user_type),
                user_id = VALUES(user_id),
                username = VALUES(username),
                ip_address = VALUES(ip_address),
                user_agent = VALUES(user_agent),
                last_activity = VALUES(last_activity),
                current_url = VALUES(current_url)";

        return $this->execute($sql, [
            $data['session_id'],
            $data['user_type'],
            $data['user_id'],
            $data['username'],
            $data['ip_address'],
            $data['user_agent'],
            $data['last_activity'],
            $loginTime,
            $data['current_url'],
        ]);
    }

    public function getOnlineList(array $filters = [], int $page = 1, int $pageSize = 50)
    {
        $where = "last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)";
        $params = [];

        if (!empty($filters['user_type'])) {
            $where .= " AND user_type = ?";
            $params[] = $filters['user_type'];
        }
        if (!empty($filters['username'])) {
            $where .= " AND username LIKE ?";
            $params[] = '%' . $filters['username'] . '%';
        }
        if (!empty($filters['ip_address'])) {
            $where .= " AND ip_address = ?";
            $params[] = $filters['ip_address'];
        }

        $offset = ($page - 1) * $pageSize;

        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
        $countResult = $this->prepare($countSql, $params);
        $total = $countResult ? (int)$countResult['total'] : 0;

        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY last_activity DESC LIMIT ?, ?";
        $params[] = (int)$offset;
        $params[] = (int)$pageSize;
        $rows = $this->prepare($sql, $params, true);

        return ['rows' => $rows ?: [], 'total' => $total];
    }

    public function countOnline($userType = null)
    {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table} WHERE last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)";
        $params = [];

        if ($userType !== null) {
            $sql .= " AND user_type = ?";
            $params[] = $userType;
        }

        $result = $this->prepare($sql, $params);
        return $result ? (int)$result['cnt'] : 0;
    }

    public function countGuests()
    {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table} 
                WHERE last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND) 
                AND user_id IS NULL";
        $result = $this->query($sql);
        return $result ? (int)$result['cnt'] : 0;
    }

    public function countUniqueIps()
    {
        $sql = "SELECT COUNT(DISTINCT ip_address) as cnt FROM {$this->table} 
                WHERE last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)";
        $result = $this->query($sql);
        return $result ? (int)$result['cnt'] : 0;
    }

    public function getBySessionId($sessionId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE session_id = ? LIMIT 1";
        return $this->prepare($sql, [$sessionId]);
    }

    public function getByUser($userType, $userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_type = ? AND user_id = ? AND last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)";
        return $this->prepare($sql, [$userType, (int)$userId], true);
    }

    public function getByIp($ipAddress)
    {
        $sql = "SELECT * FROM {$this->table} WHERE ip_address = ? AND last_activity >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)";
        return $this->prepare($sql, [$ipAddress], true);
    }

    public function deleteExpired($timeoutSeconds)
    {
        $sql = "DELETE FROM {$this->table} WHERE last_activity < DATE_SUB(NOW(), INTERVAL ? SECOND)";
        return $this->execute($sql, [(int)$timeoutSeconds]);
    }

    public function deleteBySessionId($sessionId)
    {
        $sql = "DELETE FROM {$this->table} WHERE session_id = ?";
        return $this->execute($sql, [$sessionId]);
    }

    public function recordLogout(array $session, $status, $reason = null)
    {
        $sql = "INSERT INTO S_login_history 
                (user_type, user_id, username, ip_address, user_agent, login_time, logout_time, session_id, status, fail_reason)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
        return $this->execute($sql, [
            $session['user_type'],
            $session['user_id'],
            $session['username'],
            $session['ip_address'],
            $session['user_agent'],
            $session['login_time'],
            $session['session_id'],
            $status,
            $reason,
        ]);
    }

    public function getLoginHistory(array $filters = [], int $page = 1, int $pageSize = 30)
    {
        $where = "1=1";
        $params = [];

        if (!empty($filters['user_type'])) {
            $where .= " AND user_type = ?";
            $params[] = $filters['user_type'];
        }
        if (!empty($filters['username'])) {
            $where .= " AND username LIKE ?";
            $params[] = '%' . $filters['username'] . '%';
        }
        if (!empty($filters['ip_address'])) {
            $where .= " AND ip_address = ?";
            $params[] = $filters['ip_address'];
        }
        if (!empty($filters['status'])) {
            $where .= " AND status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['date_from'])) {
            $where .= " AND login_time >= ?";
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        if (!empty($filters['date_to'])) {
            $where .= " AND login_time <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }

        $offset = ($page - 1) * $pageSize;

        $countSql = "SELECT COUNT(*) as total FROM S_login_history WHERE {$where}";
        $countResult = $this->prepare($countSql, $params);
        $total = $countResult ? (int)$countResult['total'] : 0;

        $sql = "SELECT * FROM S_login_history WHERE {$where} ORDER BY login_time DESC LIMIT ?, ?";
        $params[] = (int)$offset;
        $params[] = (int)$pageSize;
        $rows = $this->prepare($sql, $params, true);

        return ['rows' => $rows ?: [], 'total' => $total];
    }
}
