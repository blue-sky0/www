<?php

namespace admin\model;

use \core\Model;

class AccessLogModel extends Model
{
    protected $table = 'S_access_logs';

    public function insert(array $data)
    {
        $sql = "INSERT INTO {$this->table} 
                (user_type, user_id, session_id, ip_address, user_agent, request_url, request_method, referer_url, page_title, response_time, response_code)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->execute($sql, [
            $data['user_type'],
            $data['user_id'],
            $data['session_id'],
            $data['ip_address'],
            $data['user_agent'],
            $data['request_url'],
            $data['request_method'],
            $data['referer_url'],
            $data['page_title'],
            $data['response_time'],
            $data['response_code'],
        ]);
    }

    public function getDailyTrend($days = 7)
    {
        $sql = "SELECT DATE(created_at) as date,
                       COUNT(*) as pv,
                       COUNT(DISTINCT session_id) as uv,
                       COUNT(DISTINCT ip_address) as ip_count
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY DATE(created_at)
                ORDER BY date ASC";
        return $this->prepare($sql, [(int)$days], true);
    }

    public function getTopPages($days = 7, $limit = 20)
    {
        $sql = "SELECT request_url,
                       ANY_VALUE(page_title) as page_title,
                       COUNT(*) as pv,
                       COUNT(DISTINCT session_id) as uv,
                       AVG(response_time) as avg_time
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY request_url
                ORDER BY pv DESC
                LIMIT ?";
        return $this->prepare($sql, [(int)$days, (int)$limit], true);
    }

    public function getTopReferrers($days = 7, $limit = 10)
    {
        $sql = "SELECT referer_url, COUNT(*) as count
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                  AND referer_url IS NOT NULL AND referer_url != ''
                GROUP BY referer_url
                ORDER BY count DESC
                LIMIT ?";
        return $this->prepare($sql, [(int)$days, (int)$limit], true);
    }

    public function getSessionPages($sessionId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE session_id = ? ORDER BY created_at ASC";
        return $this->prepare($sql, [$sessionId], true);
    }

    public function countRecent($seconds)
    {
        $sql = "SELECT COUNT(DISTINCT session_id) as cnt FROM {$this->table} 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? SECOND)";
        $result = $this->prepare($sql, [(int)$seconds]);
        return $result ? (int)$result['cnt'] : 0;
    }

    public function getAccessList(array $filters, $page = 1, $pageSize = 50)
    {
        $where = "1=1";
        $params = [];

        if (!empty($filters['user_type'])) {
            $where .= " AND user_type = ?";
            $params[] = $filters['user_type'];
        }
        if (!empty($filters['ip_address'])) {
            $where .= " AND ip_address = ?";
            $params[] = $filters['ip_address'];
        }
        if (!empty($filters['url'])) {
            $where .= " AND request_url LIKE ?";
            $params[] = '%' . $filters['url'] . '%';
        }
        if (!empty($filters['date_from'])) {
            $where .= " AND created_at >= ?";
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        if (!empty($filters['date_to'])) {
            $where .= " AND created_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }

        $offset = ($page - 1) * $pageSize;

        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
        $countResult = $this->prepare($countSql, $params);
        $total = $countResult ? (int)$countResult['total'] : 0;

        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY created_at DESC LIMIT ?, ?";
        $params[] = (int)$offset;
        $params[] = (int)$pageSize;
        $rows = $this->prepare($sql, $params, true);

        return ['rows' => $rows ?: [], 'total' => $total];
    }

    public function aggregateDailyStats($date)
    {
        $sql = "INSERT INTO S_daily_stats (stat_date, total_pv, total_uv, total_ip, new_users, active_users)
                SELECT ? as stat_date,
                       COUNT(*) as total_pv,
                       COUNT(DISTINCT session_id) as total_uv,
                       COUNT(DISTINCT ip_address) as total_ip,
                       (SELECT COUNT(*) FROM S_user WHERE DATE(created_at) = ?) as new_users,
                       COUNT(DISTINCT CASE WHEN user_type = 'user' THEN user_id END) as active_users
                FROM {$this->table}
                WHERE DATE(created_at) = ?
                ON DUPLICATE KEY UPDATE
                    total_pv = VALUES(total_pv),
                    total_uv = VALUES(total_uv),
                    total_ip = VALUES(total_ip),
                    new_users = VALUES(new_users),
                    active_users = VALUES(active_users)";
        return $this->execute($sql, [$date, $date, $date]);
    }

    public function aggregatePageStats($date)
    {
        $sql = "INSERT INTO S_page_stats (stat_date, page_url, page_title, pv, uv, ip_count, avg_time)
                SELECT ? as stat_date,
                       request_url, page_title,
                       COUNT(*) as pv,
                       COUNT(DISTINCT session_id) as uv,
                       COUNT(DISTINCT ip_address) as ip_count,
                       AVG(response_time) as avg_time
                FROM {$this->table}
                WHERE DATE(created_at) = ?
                GROUP BY request_url
                ON DUPLICATE KEY UPDATE
                    pv = VALUES(pv),
                    uv = VALUES(uv),
                    ip_count = VALUES(ip_count),
                    avg_time = VALUES(avg_time)";
        return $this->execute($sql, [$date, $date]);
    }

    public function deleteOldLogs($keepDays = 90)
    {
        $sql = "DELETE FROM {$this->table} WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        return $this->execute($sql, [(int)$keepDays]);
    }
}
