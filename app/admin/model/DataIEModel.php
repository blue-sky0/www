<?php

namespace admin\model;

use core\Model;

class DataIEModel extends Model
{
    public function getTableColumns($shortName)
    {
        $fullTable = $this->getTable($shortName);
        $sql = "DESC `{$fullTable}`";
        return $this->query($sql, true) ?: [];
    }

    public function getRowCount($shortName)
    {
        $fullTable = $this->getTable($shortName);
        $sql = "SELECT COUNT(*) as cnt FROM `{$fullTable}`";
        $result = $this->prepare($sql, [], true);
        return $result ? (int)$result[0]['cnt'] : 0;
    }

    public function getPageData($shortName, $page = 1, $pageSize = 20)
    {
        $fullTable = $this->getTable($shortName);
        $offset = ($page - 1) * $pageSize;

        $countResult = $this->prepare("SELECT COUNT(*) as cnt FROM `{$fullTable}`", [], true);
        $total = $countResult ? (int)$countResult[0]['cnt'] : 0;

        $sql = "SELECT * FROM `{$fullTable}` LIMIT ?, ?";
        $data = $this->prepare($sql, [(int)$offset, (int)$pageSize], true);

        $totalPages = max(1, ceil($total / $pageSize));

        return [
            'total'      => $total,
            'totalPages' => $totalPages,
            'page'       => $page,
            'pageSize'   => $pageSize,
            'data'       => $data ?: [],
        ];
    }

    public function getAllData($shortName, $where = '')
    {
        $fullTable = $this->getTable($shortName);
        $whereClause = '';
        if (!empty($where)) {
            $whereClause = ' WHERE ' . $where;
        }
        $sql = "SELECT * FROM `{$fullTable}`{$whereClause}";
        return $this->prepare($sql, [], true) ?: [];
    }

    public function insertRow($shortName, array $data, $importType = 'insert')
    {
        $fullTable = $this->getTable($shortName);

        if (empty($data)) {
            return false;
        }

        $insertData = array_filter($data, function ($v) {
            return $v !== null;
        });

        if (empty($insertData)) {
            return false;
        }

        $fields = '`' . implode('`, `', array_keys($insertData)) . '`';
        $placeholders = implode(', ', array_fill(0, count($insertData), '?'));
        $values = array_values($insertData);

        switch ($importType) {
            case 'replace':
                $sql = "REPLACE INTO `{$fullTable}` ({$fields}) VALUES ({$placeholders})";
                break;
            case 'update':
                $setParts = [];
                foreach (array_keys($insertData) as $f) {
                    $setParts[] = "`{$f}` = VALUES(`{$f}`)";
                }
                $setStr = implode(', ', $setParts);
                $sql = "INSERT INTO `{$fullTable}` ({$fields}) VALUES ({$placeholders}) ON DUPLICATE KEY UPDATE {$setStr}";
                break;
            case 'insert':
            default:
                $sql = "INSERT INTO `{$fullTable}` ({$fields}) VALUES ({$placeholders})";
                break;
        }

        return $this->execute($sql, $values);
    }

    public function executeRawInsert($shortName, $insertSql)
    {
        $fullTable = $this->getTable($shortName);
        $sql = str_replace('S_' . $shortName, $fullTable, $insertSql);
        $sql = str_replace('`' . $fullTable . '`', "`{$fullTable}`", $sql);
        return $this->exec($sql);
    }

    public function truncateTable($shortName)
    {
        $fullTable = $this->getTable($shortName);
        $countResult = $this->prepare("SELECT COUNT(*) as cnt FROM `{$fullTable}`", [], true);
        $count = $countResult ? (int)$countResult[0]['cnt'] : 0;
        $sql = "TRUNCATE TABLE `{$fullTable}`";
        $this->exec($sql);
        return $count;
    }

    public function getSubjectList()
    {
        $fullTable = $this->getTable('subject');
        $sql = "SELECT subject FROM `{$fullTable}` GROUP BY subject ORDER BY MIN(id)";
        $rows = $this->query($sql, true);
        return $rows ? array_column($rows, 'subject') : [];
    }

    public function checkPageExists($subject, $page)
    {
        $fullTable = $this->getTable('rightContent');
        $sql = "SELECT id FROM `{$fullTable}` WHERE subject = ? AND page = ? LIMIT 1";
        $stmt = $this->prepare($sql, [$subject, $page], true);
        return $stmt ? (int)$stmt[0]['id'] : 0;
    }

    public function insertContent(array $data)
    {
        $fields = '`' . implode('`, `', array_keys($data)) . '`';
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `{$this->getTable('rightContent')}` ({$fields}) VALUES ({$placeholders})";
        $this->execute($sql, array_values($data));
        return $this->getLastId();
    }

    public function updateContent($subject, $page, array $data)
    {
        $data['alter_date'] = date('Y-m-d H:i:s');
        $sets = [];
        $values = [];
        foreach ($data as $k => $v) {
            $sets[] = "`{$k}` = ?";
            $values[] = $v;
        }
        $values[] = $subject;
        $values[] = $page;
        $sql = "UPDATE `{$this->getTable('rightContent')}` SET " . implode(', ', $sets) . " WHERE subject = ? AND page = ?";
        $this->execute($sql, $values);
        return true;
    }
}
