<?php

namespace admin\model;

use core\Model;

class OperationLogModel extends Model
{
    protected $table = 'operation_logs';

    public function getLogs($page = 1, $pageSize = 20, $filters = [])
    {
        $where = '1=1';
        $params = [];

        if (!empty($filters['module'])) {
            $where .= ' AND module = ?';
            $params[] = $filters['module'];
        }
        if (!empty($filters['username'])) {
            $where .= ' AND username LIKE ?';
            $params[] = '%' . $filters['username'] . '%';
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $where .= ' AND status = ?';
            $params[] = (int)$filters['status'];
        }
        if (!empty($filters['date_from'])) {
            $where .= ' AND created_at >= ?';
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        if (!empty($filters['date_to'])) {
            $where .= ' AND created_at <= ?';
            $params[] = $filters['date_to'] . ' 23:59:59';
        }

        $offset = ($page - 1) * $pageSize;

        $countSql = "SELECT COUNT(*) as cnt FROM {$this->getTable()} WHERE {$where}";
        $countResult = $this->prepare($countSql, $params);
        $total = $countResult ? (int)$countResult['cnt'] : 0;

        $sql = "SELECT * FROM {$this->getTable()} WHERE {$where} ORDER BY created_at DESC LIMIT {$pageSize} OFFSET {$offset}";
        $rows = $this->prepare($sql, $params, true);

        return ['rows' => $rows, 'total' => $total];
    }

    public function getRecent($limit = 10)
    {
        $sql = "SELECT * FROM {$this->getTable()} ORDER BY created_at DESC LIMIT ?";
        $rows = $this->prepare($sql, [(int)$limit], true);
        return $rows ?: [];
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = ?";
        return $this->prepare($sql, [(int)$id]);
    }

    public function getDistinctModules()
    {
        $sql = "SELECT DISTINCT module FROM {$this->getTable()} WHERE module IS NOT NULL ORDER BY module";
        $rows = $this->prepare($sql, [], true);
        return array_column($rows, 'module');
    }

    public function addLog(array $data)
    {
        return $this->addTableData($data);
    }

    public function cleanOldLogs($keepDays = 90)
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        return $this->execute($sql, [(int)$keepDays]);
    }

    public function getAllLogs($filters = [], $limit = 10000)
    {
        $where = '1=1';
        $params = [];

        if (!empty($filters['module'])) {
            $where .= ' AND module = ?';
            $params[] = $filters['module'];
        }
        if (!empty($filters['date_from'])) {
            $where .= ' AND created_at >= ?';
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        if (!empty($filters['date_to'])) {
            $where .= ' AND created_at <= ?';
            $params[] = $filters['date_to'] . ' 23:59:59';
        }

        $sql = "SELECT * FROM {$this->getTable()} WHERE {$where} ORDER BY created_at DESC LIMIT {$limit}";
        return $this->prepare($sql, $params, true);
    }
}
