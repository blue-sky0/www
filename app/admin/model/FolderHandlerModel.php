<?php

namespace admin\model;

use core\Model;

class FolderHandlerModel extends Model
{
    private $allowedBasePath;

    public function __construct()
    {
        $this->allowedBasePath = realpath(dirname(dirname(dirname(__DIR__))) . '/public/images');
    }

    // 验证并解析安全路径
    public function resolveSafePath($path)
    {
        // 移除路径遍历攻击字符
        $path = str_replace(['..', "\0"], '', $path);
        $realPath = realpath($path);

        if ($realPath === false) {
            return $this->allowedBasePath;
        }

        // 确保路径在允许的基目录下
        if (strpos($realPath, $this->allowedBasePath) !== 0) {
            return $this->allowedBasePath;
        }

        return $realPath;
    }

    public function getFolderFiles($path)
    {
        // 验证路径安全
        $path = $this->resolveSafePath($path);

        $folderfiles = [];
        $types = '';
        $files = scandir($path);
        foreach ($files as $file) {
            $filePath = $path . '/' . $file;
            if ($file === '.' || $file === '..') {
                continue; // 跳过当前目录和上级目录
            }
            if (is_dir($filePath)) {
                $types = 'folder';
                $folderSize = $this->getFolderSize($filePath);
            } else {
                $types = 'file';
                $folderSize = $this->formatBytes(filesize($filePath));
            }

            $folderfiles[] = [
                'name' => $file,                                                    // 文件或文件夹名称
                'type' => $types,                                                   // 文件类型：文件夹或文件
                'extension' => pathinfo($filePath, PATHINFO_EXTENSION),             // 文件扩展名
                'parentPath' => $path,                                              // 父目录路径
                'currentPath' => $filePath,                                         // 当前文件或文件夹路径
                'CreationTime' => date('Y-m-d H:i:s', filectime($filePath)),        // 创建时间
                'ModificationTime' => date('Y-m-d H:i:s', filemtime($filePath)),    // 修改时间
                'accessTime' => date('Y-m-d H:i:s', fileatime($filePath)),          // 访问时间
                'fileSize' => $folderSize                                           // 文件或文件夹大小
            ];

        }
        return $folderfiles;
    }

    /**
    * 格式化字节大小
    */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    // 文件夹的大小
    protected function getFolderSize($folderPath)
    {
        $size = 0;
        $path = realpath($folderPath);
        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $object) {
                $size += $object->getSize();
            }
        }
        return $this->formatBytes($size);
    }


}
