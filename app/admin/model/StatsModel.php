<?php

namespace admin\model;

use \core\Model;

class StatsModel extends Model
{
    public function getUserStats()
    {
        $sql = "SELECT COUNT(*) as total FROM S_user";
        $total = $this->query($sql);
        $sql = "SELECT COUNT(*) as admin_count FROM S_user WHERE is_admin = 1";
        $admins = $this->query($sql);
        return [
            'total_users' => $total ? (int)$total['total'] : 0,
            'admin_users' => $admins ? (int)$admins['admin_count'] : 0,
        ];
    }

    public function getContentCount()
    {
        $count = 0;
        if ($this->tableExists('S_subject')) {
            $sql = "SELECT COUNT(*) as total FROM S_subject";
            $result = $this->query($sql);
            $count += $result ? (int)$result['total'] : 0;
        }
        if ($this->tableExists('S_course')) {
            $sql = "SELECT COUNT(*) as total FROM S_course";
            $result = $this->query($sql);
            $count += $result ? (int)$result['total'] : 0;
        }
        return $count;
    }

    public function getImageCount()
    {
        $imageDir = dirname(dirname(dirname(__DIR__))) . '/public/images';
        $count = 0;
        if (is_dir($imageDir)) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($imageDir));
            foreach ($files as $file) {
                if ($file->isFile() && in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'])) {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function getVideoCount()
    {
        $videoDir = dirname(dirname(dirname(__DIR__))) . '/public/images/video';
        $count = 0;
        if (is_dir($videoDir)) {
            $files = new \FilesystemIterator($videoDir, \FilesystemIterator::SKIP_DOTS);
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function getStorageSize()
    {
        $publicDir = dirname(dirname(dirname(__DIR__))) . '/public';
        $total = 0;
        $dirs = [
            $publicDir . '/images',
            $publicDir . '/files',
        ];
        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                $total += $this->dirSize($dir);
            }
        }
        return $this->formatBytes($total);
    }

    public function getRecentLogStats($days = 7)
    {
        $table = $this->getLogTable();
        if (!$table) {
            return [];
        }
        $cutoff = date('Y-m-d', strtotime("-{$days} days"));
        $sql = "SELECT DATE(created_at) as date, COUNT(*) as count
                FROM {$table}
                WHERE created_at >= ?
                GROUP BY DATE(created_at)
                ORDER BY date ASC";
        return $this->prepare($sql, [$cutoff], true);
    }

    public function getLogModuleStats()
    {
        $table = $this->getLogTable();
        if (!$table) {
            return [];
        }
        $sql = "SELECT module, COUNT(*) as count
                FROM {$table}
                GROUP BY module
                ORDER BY count DESC
                LIMIT 10";
        return $this->prepare($sql, [], true);
    }

    public function getRegistrationTrend($days = 7)
    {
        $cutoff = strtotime("-{$days} days");
        $sql = "SELECT DATE(FROM_UNIXTIME(reg_time)) as date, COUNT(*) as count
                FROM S_user
                WHERE reg_time >= ?
                GROUP BY DATE(FROM_UNIXTIME(reg_time))
                ORDER BY date ASC";
        return $this->prepare($sql, [$cutoff], true);
    }

    public function getContentCategoryStats()
    {
        if ($this->tableExists('S_course')) {
            $sql = "SELECT c.course as category, COUNT(s.id) as count
                    FROM S_course c
                    LEFT JOIN S_subject s ON c.id = s.course
                    GROUP BY c.id, c.course
                    ORDER BY count DESC
                    LIMIT 10";
            return $this->prepare($sql, [], true);
        }
        return [];
    }

    public function getDailyNewUsers($days = 7)
    {
        $cutoff = strtotime("-{$days} days");
        $sql = "SELECT DATE(FROM_UNIXTIME(reg_time)) as date, COUNT(*) as count
                FROM S_user
                WHERE reg_time >= ?
                GROUP BY DATE(FROM_UNIXTIME(reg_time))
                ORDER BY date ASC";
        return $this->prepare($sql, [$cutoff], true);
    }

    public function getMysqlVersion()
    {
        $sql = "SELECT VERSION() as version";
        $result = $this->query($sql);
        return $result ? $result['version'] : 'unknown';
    }

    public function getOnlineUserCount()
    {
        if ($this->tableExists('S_online_users')) {
            $sql = "SELECT COUNT(*) as count FROM S_online_users WHERE last_activity > ?";
            $threshold = time() - 900;
            $result = $this->prepare($sql, [$threshold], true);
            return $result ? (int)$result[0]['count'] : 0;
        }
        return 0;
    }

    public function getDatabaseSize()
    {
        $config = $GLOBALS['config'] ?? [];
        $dbName = $config['database']['dbname'] ?? '';
        if (empty($dbName)) {
            return '0 MB';
        }
        $sql = "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size
                FROM information_schema.tables
                WHERE table_schema = ?";
        $result = $this->prepare($sql, [$dbName], true);
        $size = $result ? (float)$result[0]['size'] : 0;
        return $size . ' MB';
    }

    public function getLastBackupTime()
    {
        if ($this->tableExists('S_settings')) {
            $sql = "SELECT `value` FROM S_settings WHERE group_name = ? AND key_name = ? LIMIT 1";
            $result = $this->prepare($sql, ['system', 'last_backup_time'], true);
            return $result ? $result[0]['value'] : null;
        }
        return null;
    }

    public function getTodayNewUsers()
    {
        $today = date('Y-m-d');
        $sql = "SELECT COUNT(*) as count FROM S_user WHERE DATE(FROM_UNIXTIME(reg_time)) = ?";
        $result = $this->prepare($sql, [$today], true);
        return $result ? (int)$result[0]['count'] : 0;
    }

    public function getTodayOperations()
    {
        if ($this->tableExists('S_operation_logs')) {
            $today = date('Y-m-d');
            $sql = "SELECT COUNT(*) as count FROM S_operation_logs WHERE DATE(created_at) = ?";
            $result = $this->prepare($sql, [$today], true);
            return $result ? (int)$result[0]['count'] : 0;
        }
        return 0;
    }

    private function getLogTable()
    {
        if ($this->tableExists('S_operation_logs')) {
            return 'S_operation_logs';
        }
        if ($this->tableExists('S_operation_log')) {
            return 'S_operation_log';
        }
        return null;
    }

    private function tableExists($table)
    {
        $sql = "SHOW TABLES LIKE ?";
        $result = $this->prepare($sql, [$table]);
        return !empty($result);
    }

    private function dirSize($dir)
    {
        $size = 0;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        return $size;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / (1024 ** $pow), $precision) . ' ' . $units[$pow];
    }
}
