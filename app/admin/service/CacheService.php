<?php

namespace admin\service;

class CacheService
{
    private $cacheDir;

    const TYPE_PAGE      = 'page';
    const TYPE_DATA      = 'data';
    const TYPE_QUERY     = 'query';
    const TYPE_TEMPLATE  = 'template';
    const TYPE_THUMBNAIL = 'thumbnail';

    const TYPES = [
        self::TYPE_PAGE      => ['dir' => 'page',      'label' => '页面缓存',       'max_age' => 300],
        self::TYPE_DATA      => ['dir' => 'data',      'label' => '数据缓存',       'max_age' => 600],
        self::TYPE_QUERY     => ['dir' => 'query',     'label' => '数据库查询缓存',  'max_age' => 120],
        self::TYPE_TEMPLATE  => ['dir' => 'template',  'label' => '模板编译缓存',    'max_age' => 86400],
        self::TYPE_THUMBNAIL => ['dir' => 'thumbnail', 'label' => '缩略图缓存',     'max_age' => 604800],
    ];

    private const COMPILE_DIRS = [
        'app/admin/template_c/',
        'app/home/template_c/',
        'cache/',
        'temp/',
    ];

    public function __construct()
    {
        $root = dirname(dirname(dirname(__DIR__)));
        $this->cacheDir = $root . '/cache';
        $this->ensureDir($this->cacheDir);

        foreach (self::TYPES as $type) {
            $this->ensureDir($this->cacheDir . '/' . $type['dir']);
        }
    }

    public function getStats(): array
    {
        $stats = [];

        foreach (self::TYPES as $key => $config) {
            $dir = $this->cacheDir . '/' . $config['dir'];
            $files = $this->scanFiles($dir);

            $totalSize = 0;
            $fileCount = 0;
            $newest = 0;
            $oldest = PHP_INT_MAX;

            foreach ($files as $file) {
                $totalSize += $file['size'];
                $fileCount++;
                $newest = max($newest, $file['mtime']);
                $oldest = min($oldest, $file['mtime']);
            }

            $expiredCount = 0;
            $expireTime = time() - $config['max_age'];
            foreach ($files as $file) {
                if ($file['mtime'] < $expireTime) $expiredCount++;
            }

            $stats[$key] = [
                'label'         => $config['label'],
                'file_count'    => $fileCount,
                'total_size'    => $totalSize,
                'size_fmt'      => $this->formatSize($totalSize),
                'newest'        => $newest ? date('Y-m-d H:i:s', $newest) : '-',
                'oldest'        => $oldest < PHP_INT_MAX ? date('Y-m-d H:i:s', $oldest) : '-',
                'max_age'       => $config['max_age'],
                'expired_count' => $expiredCount,
            ];
        }

        $totalFiles = array_sum(array_column($stats, 'file_count'));
        $totalSize = array_sum(array_column($stats, 'total_size'));
        $totalExpired = array_sum(array_column($stats, 'expired_count'));

        $smartySize = 0;
        $smartyFiles = 0;
        $smartyDirs = [
            dirname($this->cacheDir) . '/app/admin/template_c',
            dirname($this->cacheDir) . '/app/home/template_c',
        ];
        foreach ($smartyDirs as $dir) {
            if (is_dir($dir)) {
                $files = $this->scanFiles($dir);
                $smartyFiles += count($files);
                $smartySize += array_sum(array_column($files, 'size'));
            }
        }

        return [
            'types'          => $stats,
            'total_files'    => $totalFiles,
            'total_size'     => $totalSize,
            'size_fmt'       => $this->formatSize($totalSize),
            'total_expired'  => $totalExpired,
            'smarty_size'    => $smartySize,
            'smarty_files'   => $smartyFiles,
            'smarty_size_fmt'=> $this->formatSize($smartySize),
        ];
    }

    public function clearType(string $type): array
    {
        if (!isset(self::TYPES[$type])) {
            return ['success' => false, 'error' => '未知缓存类型'];
        }

        $dir = $this->cacheDir . '/' . self::TYPES[$type]['dir'];
        $count = $this->deleteFiles($dir);

        return ['success' => true, 'message' => "已清理 {$count} 个文件", 'count' => $count];
    }

    public function clearAll(): array
    {
        $total = 0;
        foreach (self::TYPES as $type => $config) {
            $dir = $this->cacheDir . '/' . $config['dir'];
            $total += $this->deleteFiles($dir);
        }

        foreach (self::COMPILE_DIRS as $dir) {
            $fullPath = dirname($this->cacheDir) . '/' . $dir;
            if (is_dir($fullPath)) {
                $total += $this->deleteFiles($fullPath);
            }
        }

        return ['success' => true, 'message' => "已清理 {$total} 个缓存文件", 'count' => $total];
    }

    public function clearExpired(): array
    {
        $total = 0;
        foreach (self::TYPES as $type => $config) {
            $dir = $this->cacheDir . '/' . $config['dir'];
            $files = $this->scanFiles($dir);
            $expireTime = time() - $config['max_age'];

            foreach ($files as $file) {
                if ($file['mtime'] < $expireTime) {
                    @unlink($file['path']);
                    $total++;
                }
            }
        }

        return ['success' => true, 'message' => "已清理 {$total} 个过期缓存文件", 'count' => $total];
    }

    public function set(string $key, $value, int $ttl = 600, string $type = 'data'): bool
    {
        if (!isset(self::TYPES[$type])) return false;

        $dir = $this->cacheDir . '/' . self::TYPES[$type]['dir'];
        $filepath = $dir . '/' . md5($key) . '.cache';

        $data = [
            'expire_at' => time() + $ttl,
            'value'     => $value,
        ];

        return file_put_contents($filepath, serialize($data), LOCK_EX) !== false;
    }

    public function get(string $key, string $type = 'data')
    {
        if (!isset(self::TYPES[$type])) return null;

        $filepath = $this->cacheDir . '/' . self::TYPES[$type]['dir'] . '/' . md5($key) . '.cache';

        if (!file_exists($filepath)) return null;

        $data = @unserialize(file_get_contents($filepath));
        if ($data === false) return null;

        if ($data['expire_at'] <= time()) {
            @unlink($filepath);
            return null;
        }

        return $data['value'];
    }

    public function delete(string $key, string $type = 'data'): bool
    {
        $filepath = $this->cacheDir . '/' . self::TYPES[$type]['dir'] . '/' . md5($key) . '.cache';
        if (file_exists($filepath)) {
            return @unlink($filepath);
        }
        return true;
    }

    public function getRecommendations(): array
    {
        $stats = $this->getStats();
        $recommendations = [];

        foreach ($stats['types'] as $key => $stat) {
            if ($stat['expired_count'] > $stat['file_count'] * 0.5 && $stat['file_count'] > 10) {
                $recommendations[] = "{$stat['label']} 过期文件占比过高（{$stat['expired_count']}/{$stat['file_count']}），建议清理";
            }
        }

        if ($stats['total_size'] > 100 * 1024 * 1024) {
            $recommendations[] = "缓存总大小超过 100MB，建议启用自动清理或缩小 TTL";
        }

        if ($stats['total_files'] > 10000) {
            $recommendations[] = "缓存文件数超过 10000 个，建议使用 Redis/Memcache 替代文件缓存";
        }

        if (empty($recommendations)) {
            $recommendations[] = '缓存状态良好，无需优化';
        }

        return $recommendations;
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    private function scanFiles(string $dir): array
    {
        if (!is_dir($dir)) return [];

        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = [
                    'path'  => $file->getPathname(),
                    'name'  => $file->getFilename(),
                    'size'  => $file->getSize(),
                    'mtime' => $file->getMTime(),
                ];
            }
        }

        return $files;
    }

    private function deleteFiles(string $dir): int
    {
        if (!is_dir($dir)) return 0;

        $count = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isFile() && @unlink($item->getPathname())) {
                $count++;
            } elseif ($item->isDir() && @rmdir($item->getPathname())) {
            }
        }

        return $count;
    }

    private function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 4) { $bytes /= 1024; $i++; }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
