<?php

namespace admin\service;

class OptimizationService
{
    private function getPdo(): ?\PDO
    {
        try {
            $ref = new \ReflectionClass(\core\Model::class);
            $daoProp = $ref->getProperty('dao');
            $daoProp->setAccessible(true);
            $model = new \core\Model();
            $dao = $daoProp->getValue($model);
            $refDao = new \ReflectionClass($dao);
            $pdoProp = $refDao->getProperty('pdo');
            $pdoProp->setAccessible(true);
            return $pdoProp->getValue($dao);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function getTableStatus(): array
    {
        $tables = [];

        try {
            $pdo = $this->getPdo();
            if (!$pdo) return ['error' => '数据库连接失败'];

            $dbName = $this->getDbName($pdo);

            $stmt = $pdo->query("SHOW TABLE STATUS FROM `{$dbName}`");
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!$rows) $rows = [];

            foreach ($rows as $row) {
                $tables[] = [
                    'name'       => $row['Name'],
                    'engine'     => $row['Engine'],
                    'rows'       => $row['Rows'],
                    'data_size'  => $this->formatSize($row['Data_length']),
                    'index_size' => $this->formatSize($row['Index_length']),
                    'total_size' => $this->formatSize($row['Data_length'] + $row['Index_length']),
                    'collation'  => $row['Collation'],
                    'overhead'   => $row['Data_free'] > 0 ? $this->formatSize($row['Data_free']) : '-',
                    'auto_inc'   => $row['Auto_increment'],
                    'updated_at' => $row['Update_time'] ?? '-',
                ];
            }
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }

        return $tables;
    }

    public function optimizeTable(string $tableName): array
    {
        try {
            $pdo = $this->getPdo();
            if (!$pdo) return ['success' => false, 'error' => '数据库连接失败'];
            $pdo->query("OPTIMIZE TABLE `{$tableName}`");
            return ['success' => true, 'message' => "表 {$tableName} 优化完成"];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function optimizeAllTables(): array
    {
        $results = [];

        try {
            $pdo = $this->getPdo();
            if (!$pdo) return ['success' => false, 'error' => '数据库连接失败'];

            $dbName = $this->getDbName($pdo);
            $stmt = $pdo->query("SHOW TABLE STATUS FROM `{$dbName}`");
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!$rows) $rows = [];

            foreach ($rows as $table) {
                $name = $table['Name'];
                try {
                    $pdo->query("OPTIMIZE TABLE `{$name}`");
                    $pdo->query("ANALYZE TABLE `{$name}`");
                    $results[] = ['table' => $name, 'status' => 'OK'];
                } catch (\Throwable $e) {
                    $results[] = ['table' => $name, 'status' => '错误: ' . $e->getMessage()];
                }
            }
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }

        return ['success' => true, 'results' => $results];
    }

    private function getDbName(\PDO $pdo): string
    {
        try {
            $stmt = $pdo->query("SELECT DATABASE()");
            return $stmt->fetchColumn() ?: 'study';
        } catch (\Throwable $e) {
            return 'study';
        }
    }

    private function formatSize($bytes): string
    {
        if (!is_numeric($bytes)) return '0 B';
        $bytes = (int)$bytes;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 3) { $bytes /= 1024; $i++; }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
