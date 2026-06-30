<?php

namespace admin\controller;

class VideoController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Video');

        $getFolder = new \admin\model\FolderHandlerModel();
        $videoBase = dirname(dirname(dirname(__DIR__))) . '/public/images/video';
        $videos = [];

        if (is_dir($videoBase)) {
            $files = scandir($videoBase);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, ['mp4', 'webm', 'ogg', 'avi', 'mov', 'mkv'])) {
                    $filePath = $videoBase . '/' . $file;
                    $videos[] = [
                        'name' => $file,
                        'size' => $this->formatSize(filesize($filePath)),
                        'mtime' => date('Y-m-d H:i:s', filemtime($filePath)),
                        'path' => $filePath,
                    ];
                }
            }
            usort($videos, function ($a, $b) {
                return strtotime($b['mtime']) - strtotime($a['mtime']);
            });
        }

        $this->assign('videos', $videos);
        $this->assign("tableData", "");

        $this->display("index.php");
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }
        $this->checkCsrf();

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_msg'] = '上传失败';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $file = $_FILES['file'];
        $maxSize = 200 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $_SESSION['error_msg'] = '视频大小超过限制（最大200MB）';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $allowedMimes = ['video/mp4', 'video/webm', 'video/ogg', 'video/x-msvideo', 'video/quicktime'];
        $allowedExts = ['mp4', 'webm', 'ogg', 'avi', 'mov', 'mkv'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimes, true)) {
            $_SESSION['error_msg'] = '不支持的视频类型';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts, true)) {
            $_SESSION['error_msg'] = '不支持的文件格式';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $targetDir = dirname(dirname(dirname(__DIR__))) . '/public/images/video';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $destPath = $targetDir . '/' . $safeName;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            $_SESSION['success_msg'] = '上传成功：' . $safeName;
            $this->logOperation('video', 'upload', '上传视频：' . $safeName, 'video', $destPath);
        } else {
            $_SESSION['error_msg'] = '文件保存失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Video');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }
        $this->checkCsrf();

        $filePath = $_POST['filePath'] ?? '';
        $videoBase = realpath(dirname(dirname(dirname(__DIR__))) . '/public/images/video');

        if (empty($filePath) || !file_exists($filePath) || is_dir($filePath)) {
            $_SESSION['error_msg'] = '文件不存在';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $realPath = realpath($filePath);
        if ($videoBase === false || strpos($realPath, $videoBase) !== 0) {
            $_SESSION['error_msg'] = '不允许删除该路径的文件';
            header('Location: ' . URL . 'index.php?p=admin&c=Video');
            exit;
        }

        $fileName = basename($filePath);
        if (unlink($filePath)) {
            $_SESSION['success_msg'] = '已删除：' . $fileName;
            $this->logOperation('video', 'delete', '删除视频：' . $fileName, 'video', $filePath);
        } else {
            $_SESSION['error_msg'] = '删除失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Video');
        exit;
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 3) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
