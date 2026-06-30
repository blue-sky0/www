<?php

namespace admin\service;

class BackupService
{
    private $backupDir;
    private $dbConfig;

    public function __construct()
    {
        $this->backupDir = dirname(dirname(dirname(dirname(__DIR__)))) . '/backups/database';
        if (!is_dir($this->backupDir)) {
            @mkdir($this->backupDir, 0755, true);
        }

        $this->dbConfig = [
            'host' => getenv('DB_HOST') ?: 'localhost',
            'port' => getenv('DB_PORT') ?: '3306',
            'name' => getenv('DB_NAME') ?: '',
            'user' => getenv('DB_USER') ?: '',
            'pass' => getenv('DB_PASS') ?: '',
        ];
    }

    public function createBackup($note = '')
    {
        $timestamp = date('Ymd_His');
        $filename = "backup_{$timestamp}.sql";
        $filepath = $this->backupDir . '/' . $filename;

        $mysqldump = $this->findExecutable('mysqldump');
        if (!$mysqldump) {
            return ['success' => false, 'error' => 'mysqldump not found'];
        }

        $cmd = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers --events %s > %s 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($this->dbConfig['host']),
            escapeshellarg($this->dbConfig['port']),
            escapeshellarg($this->dbConfig['user']),
            escapeshellarg($this->dbConfig['pass']),
            escapeshellarg($this->dbConfig['name']),
            escapeshellarg($filepath)
        );

        exec($cmd, $output, $code);

        if ($code !== 0 || !file_exists($filepath)) {
            return ['success' => false, 'error' => '备份失败: ' . implode("\n", $output)];
        }

        if (function_exists('gzopen')) {
            $gzFile = $filepath . '.gz';
            $this->compressGz($filepath, $gzFile);
            @unlink($filepath);
            $filepath = $gzFile;
            $filename .= '.gz';
        }

        $metaFile = $filepath . '.meta.json';
        $meta = [
            'filename'   => $filename,
            'size'       => filesize($filepath),
            'created_at' => date('Y-m-d H:i:s'),
            'note'       => $note,
            'md5'        => md5_file($filepath),
        ];
        file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return ['success' => true, 'file' => $filename, 'size' => $meta['size']];
    }

    public function restoreBackup($filename)
    {
        $filepath = $this->backupDir . '/' . $filename;

        if (!file_exists($filepath)) {
            return ['success' => false, 'error' => '备份文件不存在'];
        }

        if (pathinfo($filename, PATHINFO_EXTENSION) === 'gz') {
            $sqlFile = substr($filepath, 0, -3);
            $this->decompressGz($filepath, $sqlFile);
            $filepath = $sqlFile;
        }

        $mysql = $this->findExecutable('mysql');
        if (!$mysql) {
            return ['success' => false, 'error' => 'mysql not found'];
        }

        $cmd = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s %s < %s 2>&1',
            escapeshellarg($mysql),
            escapeshellarg($this->dbConfig['host']),
            escapeshellarg($this->dbConfig['port']),
            escapeshellarg($this->dbConfig['user']),
            escapeshellarg($this->dbConfig['pass']),
            escapeshellarg($this->dbConfig['name']),
            escapeshellarg($filepath)
        );

        exec($cmd, $output, $code);

        if (isset($sqlFile) && $sqlFile !== $filepath) {
            @unlink($sqlFile);
        }

        if ($code !== 0) {
            return ['success' => false, 'error' => '恢复失败: ' . implode("\n", $output)];
        }

        return ['success' => true, 'message' => '数据库已恢复'];
    }

    public function getBackupList()
    {
        $files = glob($this->backupDir . '/backup_*.sql*');
        $list = [];

        foreach ($files as $file) {
            $metaFile = $file . '.meta.json';
            $meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

            $list[] = [
                'filename'    => basename($file),
                'size'        => $meta['size'] ?? filesize($file),
                'created_at'  => $meta['created_at'] ?? date('Y-m-d H:i:s', filemtime($file)),
                'note'        => $meta['note'] ?? '',
                'md5'         => $meta['md5'] ?? '',
                'meta_exists' => file_exists($metaFile),
            ];
        }

        usort($list, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $list;
    }

    public function deleteBackup($filename)
    {
        $filepath = $this->backupDir . '/' . basename($filename);
        if (!file_exists($filepath)) return false;

        @unlink($filepath);
        @unlink($filepath . '.meta.json');
        return true;
    }

    public function downloadBackup($filename)
    {
        $filepath = $this->backupDir . '/' . basename($filename);
        if (!file_exists($filepath)) {
            http_response_code(404);
            echo '文件不存在';
            return;
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
    }

    private function findExecutable($name)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $paths = [
                'C:/xampp/mysql/bin/',
                'C:/wamp64/bin/mysql/mysql8.0.*/bin/',
                'C:/Program Files/MySQL/MySQL Server 8.0/bin/',
            ];
            foreach ($paths as $path) {
                $matches = glob($path . $name . '.exe');
                if (!empty($matches)) return $matches[0];
            }
        } else {
            $output = [];
            exec("which $name 2>/dev/null", $output, $code);
            if ($code === 0 && !empty($output[0])) {
                return $output[0];
            }
        }
        return null;
    }

    private function compressGz($source, $dest)
    {
        $fpIn = fopen($source, 'rb');
        $fpOut = gzopen($dest, 'wb9');
        while (!feof($fpIn)) {
            gzwrite($fpOut, fread($fpIn, 8192));
        }
        fclose($fpIn);
        gzclose($fpOut);
    }

    private function decompressGz($source, $dest)
    {
        $fpIn = gzopen($source, 'rb');
        $fpOut = fopen($dest, 'wb');
        while (!gzeof($fpIn)) {
            fwrite($fpOut, gzread($fpIn, 8192));
        }
        gzclose($fpIn);
        fclose($fpOut);
    }

    public function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 3) { $bytes /= 1024; $i++; }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
