<?php

namespace admin\service;

class PerformanceService
{
    public function getSystemLoad(): array
    {
        $data = [];

        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $data['cpu'] = [
                '1min'     => round($load[0], 2),
                '5min'     => round($load[1], 2),
                '15min'    => round($load[2], 2),
                'cores'    => $this->getCpuCores(),
                'load_pct' => $this->getCpuUsage(),
            ];
        } else {
            $data['cpu'] = ['error' => '系统不支持'];
        }

        $data['memory'] = $this->getMemoryInfo();
        $data['disk'] = $this->getDiskInfo();

        $data['php'] = [
            'version'       => PHP_VERSION,
            'memory_limit'  => ini_get('memory_limit'),
            'max_exec_time' => ini_get('max_execution_time') . 's',
            'upload_max'    => ini_get('upload_max_filesize'),
            'post_max'      => ini_get('post_max_size'),
            'opcache'       => function_exists('opcache_get_status') ? '启用' : '未启用',
        ];

        $data['server'] = [
            'name'     => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'os'       => PHP_OS,
            'php_sapi' => PHP_SAPI,
            'time'     => date('Y-m-d H:i:s'),
            'uptime'   => $this->getUptime(),
        ];

        return $data;
    }

    public function getResponseTimes(int $days = 7): array
    {
        $logs = [];

        try {
            $model = new \core\Model();
            $ref = new \ReflectionClass($model);
            $daoProp = $ref->getProperty('dao');
            $daoProp->setAccessible(true);
            $dao = $daoProp->getValue($model);

            $sql = "SELECT created_at, response_time FROM S_access_logs 
                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
                    AND response_time IS NOT NULL
                    ORDER BY created_at ASC";
            $logs = $dao->prepare($sql, [(int)$days], true);
        } catch (\Throwable $e) {
            // silent fallback
        }

        if (!$logs) $logs = [];

        $daily = [];
        foreach ($logs as $log) {
            $date = substr($log['created_at'], 0, 10);
            if (!isset($daily[$date])) {
                $daily[$date] = ['total' => 0, 'count' => 0, 'max' => 0, 'min' => PHP_INT_MAX];
            }
            $rt = (int)$log['response_time'];
            $daily[$date]['total'] += $rt;
            $daily[$date]['count']++;
            $daily[$date]['max'] = max($daily[$date]['max'], $rt);
            $daily[$date]['min'] = min($daily[$date]['min'], $rt);
        }

        $result = [];
        foreach ($daily as $date => $info) {
            $result[] = [
                'date'  => $date,
                'avg'   => round($info['total'] / $info['count'], 0),
                'max'   => $info['max'],
                'min'   => $info['min'] === PHP_INT_MAX ? 0 : $info['min'],
                'count' => $info['count'],
            ];
        }

        ksort($result);
        return $result;
    }

    public function getDatabaseStatus(): array
    {
        try {
            return $this->queryDbStatus();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function queryDbStatus(): array
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
            $pdo = $pdoProp->getValue($dao);
        } catch (\Throwable $e) {
            return ['error' => '无法获取数据库连接'];
        }

        if (!$pdo) return ['error' => '数据库连接失败'];

        $status = [];

        try {
            $stmt = $pdo->query("SHOW GLOBAL STATUS LIKE 'Questions'");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $status['queries_total'] = $row ? $row['Value'] : 'N/A';

            $stmt = $pdo->query("SHOW GLOBAL STATUS LIKE 'Slow_queries'");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $status['slow_queries'] = $row ? $row['Value'] : 'N/A';

            $stmt = $pdo->query("SHOW GLOBAL STATUS LIKE 'Connections'");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $status['connections'] = $row ? $row['Value'] : 'N/A';

            $stmt = $pdo->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb, COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = DATABASE()");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $status['db_size_mb'] = $row['size_mb'] ?? 0;
            $status['table_count'] = $row['table_count'] ?? 0;

            $stmt = $pdo->query("SHOW VARIABLES LIKE 'slow_query_log'");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $status['slow_query_log'] = $row ? ($row['Value'] === 'ON' ? '启用' : '未启用') : 'N/A';

            $stmt = $pdo->query("SHOW PROCESSLIST");
            $processes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $status['active_connections'] = count($processes);
            $longRunning = array_filter($processes, function($p) { return ($p['Time'] ?? 0) > 30; });
            $status['long_running'] = count($longRunning);
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }

        return $status;
    }

    public function getPerformanceScore(): array
    {
        $score = 100;
        $issues = [];

        if (version_compare(PHP_VERSION, '8.0', '<')) {
            $score -= 10;
            $issues[] = 'PHP 版本 ' . PHP_VERSION . ' 较低，建议升级到 8.0+';
        }

        if (!function_exists('opcache_get_status')) {
            $score -= 15;
            $issues[] = 'OPCache 未启用，建议启用加速 PHP 执行';
        }

        $memoryLimit = ini_get('memory_limit');
        $limitBytes = $this->returnBytes($memoryLimit);
        if ($limitBytes < 128 * 1024 * 1024) {
            $score -= 10;
            $issues[] = "memory_limit ({$memoryLimit}) 过小，建议至少 128M";
        }

        $cacheDir = dirname(dirname(dirname(__DIR__))) . '/cache';
        if (!is_writable($cacheDir)) {
            $score -= 10;
            $issues[] = '缓存目录不可写';
        }

        return [
            'score'  => max(0, $score),
            'grade'  => $score >= 90 ? 'A' : ($score >= 75 ? 'B' : ($score >= 50 ? 'C' : 'D')),
            'issues' => $issues,
        ];
    }

    public function getSlowQueries(int $limit = 20): array
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
            $pdo = $pdoProp->getValue($dao);

            if (!$pdo) return [];

            $stmt = $pdo->query("SHOW FULL PROCESSLIST");
            $processes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $slow = array_filter($processes, function($p) { return ($p['Time'] ?? 0) > 2; });
            usort($slow, function($a, $b) { return $b['Time'] - $a['Time']; });

            return array_slice(array_values($slow), 0, $limit);
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function getRecentErrors(int $limit = 50): array
    {
        $logFile = ini_get('error_log');
        if (!$logFile || !file_exists($logFile)) {
            return ['error' => '错误日志文件未配置或不存在'];
        }

        $lines = [];
        $fp = @fopen($logFile, 'r');
        if ($fp) {
            fseek($fp, 0, SEEK_END);
            $pos = ftell($fp);
            $buffer = '';

            while ($pos > 0 && count($lines) < $limit) {
                $chunkSize = min(8192, $pos);
                $pos -= $chunkSize;
                fseek($fp, $pos);
                $chunk = fread($fp, $chunkSize);
                $buffer = $chunk . $buffer;

                $parts = explode("\n", $buffer);
                if (count($parts) > 1) {
                    $buffer = $parts[0];
                    for ($i = count($parts) - 1; $i >= 1 && count($lines) < $limit; $i--) {
                        if (trim($parts[$i])) {
                            $lines[] = $parts[$i];
                        }
                    }
                }
            }

            if (trim($buffer) && count($lines) < $limit) {
                $lines[] = $buffer;
            }

            fclose($fp);
        }

        return array_reverse($lines);
    }

    public function getPhpOptimizationTips(): array
    {
        $tips = [];

        if (!function_exists('opcache_get_status')) {
            $tips[] = ['severity' => 'high', 'title' => '启用 OPCache', 'desc' => 'OPCache 可大幅提升 PHP 执行性能', 'fix' => '在 php.ini 中启用: opcache.enable=1, opcache.memory_consumption=128'];
        } else {
            $status = @opcache_get_status(false);
            if ($status && isset($status['memory_usage'])) {
                $usage = $status['memory_usage'];
                $hitRate = $usage['used_memory'] > 0
                    ? round($status['opcache_statistics']['hits'] / ($status['opcache_statistics']['hits'] + $status['opcache_statistics']['misses']) * 100, 1)
                    : 0;
                $tips[] = ['severity' => 'info', 'title' => 'OPCache 命中率', 'desc' => "当前命中率: {$hitRate}%", 'fix' => $hitRate < 85 ? '增大 opcache.memory_consumption 和 opcache.max_accelerated_files' : '状态良好'];
            }
        }

        $maxExec = ini_get('max_execution_time');
        if ($maxExec < 30) {
            $tips[] = ['severity' => 'low', 'title' => 'max_execution_time', 'desc' => "当前 {$maxExec}s 过小，当心长任务被中断", 'fix' => '建议设为 120s 或更高'];
        }

        $uploadMax = ini_get('upload_max_filesize');
        if ($this->returnBytes($uploadMax) < 8 * 1024 * 1024) {
            $tips[] = ['severity' => 'low', 'title' => 'upload_max_filesize', 'desc' => "当前 {$uploadMax}，上传大文件受限", 'fix' => '建议设为 20M 或以上'];
        }

        $displayErrors = ini_get('display_errors');
        if ($displayErrors && (!defined('APP_DEBUG') || (defined('APP_DEBUG') && !APP_DEBUG))) {
            $tips[] = ['severity' => 'high', 'title' => '生产环境错误显示', 'desc' => 'display_errors 在生产环境中应关闭', 'fix' => 'php.ini: display_errors=Off, log_errors=On'];
        }

        if (!in_array('ob_gzhandler', ob_list_handlers()) && !extension_loaded('zlib')) {
            $tips[] = ['severity' => 'medium', 'title' => '启用 Gzip 压缩', 'desc' => 'Gzip 压缩可减少 70% 传输数据', 'fix' => '在 .htaccess 或 vhost 中启用 mod_deflate'];
        }

        return $tips;
    }

    private function getCpuCores(): int
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $cores = getenv('NUMBER_OF_PROCESSORS');
            return $cores ? intval($cores) : 1;
        }
        $result = trim(shell_exec('nproc 2>/dev/null') ?: '1');
        return max(1, (int)$result);
    }

    private function getCpuUsage(): ?float
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('wmic cpu get loadpercentage 2>nul');
            if ($output && preg_match('/\d+/', $output, $m)) {
                return floatval($m[0]);
            }
            return null;
        }

        $load = sys_getloadavg();
        $cores = $this->getCpuCores();
        return $cores > 0 ? round(($load[0] / $cores) * 100, 1) : null;
    }

    private function getMemoryInfo(): array
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('wmic OS get TotalVisibleMemorySize,FreePhysicalMemory /format:csv 2>nul');
            if ($output) {
                $lines = explode("\n", trim($output));
                if (count($lines) >= 2) {
                    $parts = explode(',', $lines[1]);
                    if (count($parts) >= 3) {
                        $totalKb = intval($parts[1]);
                        $freeKb = intval($parts[2]);
                        return [
                            'total_mb' => round($totalKb / 1024, 1),
                            'free_mb'  => round($freeKb / 1024, 1),
                            'used_mb'  => round(($totalKb - $freeKb) / 1024, 1),
                            'usage_pct'=> round(($totalKb - $freeKb) / $totalKb * 100, 1),
                        ];
                    }
                }
            }
        } else {
            $output = @file_get_contents('/proc/meminfo');
            if ($output && preg_match('/MemTotal:\s+(\d+)/', $output, $mt) && preg_match('/MemFree:\s+(\d+)/', $output, $mf)) {
                $totalKb = intval($mt[1]);
                $freeKb = intval($mf[1]);
                return [
                    'total_mb' => round($totalKb / 1024, 1),
                    'free_mb'  => round($freeKb / 1024, 1),
                    'used_mb'  => round(($totalKb - $freeKb) / 1024, 1),
                    'usage_pct'=> round(($totalKb - $freeKb) / $totalKb * 100, 1),
                ];
            }
        }

        return ['error' => '无法获取内存信息'];
    }

    private function getDiskInfo(): array
    {
        $root = dirname(dirname(dirname(__DIR__)));
        $total = @disk_total_space($root);
        $free = @disk_free_space($root);

        if ($total === false) {
            return ['error' => '无法获取磁盘信息'];
        }

        return [
            'total_gb'  => round($total / 1024 / 1024 / 1024, 2),
            'free_gb'   => round($free / 1024 / 1024 / 1024, 2),
            'used_gb'   => round(($total - $free) / 1024 / 1024 / 1024, 2),
            'usage_pct' => round(($total - $free) / $total * 100, 1),
        ];
    }

    private function getUptime(): ?string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('wmic os get lastbootuptime 2>nul');
            if ($output && preg_match('/(\d{14})/', $output, $m)) {
                $bootTime = date_create_from_format('YmdHis', $m[1]);
                if ($bootTime) {
                    $diff = (new \DateTime())->diff($bootTime);
                    return $diff->days . '天 ' . $diff->h . '小时 ' . $diff->i . '分钟';
                }
            }
            return null;
        }

        $output = @file_get_contents('/proc/uptime');
        if ($output) {
            $uptime = floatval(explode(' ', $output)[0]);
            $days = floor($uptime / 86400);
            $hours = floor(($uptime % 86400) / 3600);
            $minutes = floor(($uptime % 3600) / 60);
            return "{$days}天 {$hours}小时 {$minutes}分钟";
        }

        return null;
    }

    private function returnBytes(string $size): int
    {
        $size = trim($size);
        $unit = strtolower(substr($size, -1));
        $value = intval($size);

        switch ($unit) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }

        return $value;
    }
}
