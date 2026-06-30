<?php

namespace admin\controller;

class ImageController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Image');

        $getFolder = new \admin\model\FolderHandlerModel();
        $path = $_REQUEST['path'] ?? $getFolder->resolveSafePath('');
        if (isset($_REQUEST['path'])) {
            $this->checkCsrf();
        }
        $folderFiles = $getFolder->getFolderFiles($path);

        $this->assign("filedata", $folderFiles);
        $this->assign("typePath", basename($path));
        $this->assign("currentPath", $path);
        $this->assign("tableData", "");

        $this->display("index.php");
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Image');
            exit;
        }
        $this->checkCsrf();

        $getFolder = new \admin\model\FolderHandlerModel();
        $targetDir = isset($_POST['path']) ? $getFolder->resolveSafePath($_POST['path']) : $getFolder->resolveSafePath('');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_msg'] = '文件上传失败';
            header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty($targetDir) ? '&path=' . urlencode($targetDir) : ''));
            exit;
        }

        $file = $_FILES['file'];
        $maxSize = 10 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $_SESSION['error_msg'] = '文件大小超过限制（最大10MB）';
            header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty($targetDir) ? '&path=' . urlencode($targetDir) : ''));
            exit;
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimes, true)) {
            $_SESSION['error_msg'] = '不支持的文件类型';
            header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty($targetDir) ? '&path=' . urlencode($targetDir) : ''));
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts, true)) {
            $_SESSION['error_msg'] = '不支持的文件扩展名';
            header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty($targetDir) ? '&path=' . urlencode($targetDir) : ''));
            exit;
        }

        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $destPath = $targetDir . '/' . $safeName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            $_SESSION['success_msg'] = '上传成功：' . $safeName;
            $this->logOperation('image', 'upload', '上传图片：' . $safeName, 'image', $destPath);
        } else {
            $_SESSION['error_msg'] = '文件保存失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty($targetDir) ? '&path=' . urlencode($targetDir) : ''));
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Image');
            exit;
        }
        $this->checkCsrf();

        $getFolder = new \admin\model\FolderHandlerModel();
        $filePath = isset($_POST['filePath']) ? $getFolder->resolveSafePath($_POST['filePath']) : '';

        if (!file_exists($filePath) || is_dir($filePath)) {
            $_SESSION['error_msg'] = '文件不存在或无法删除目录';
            header('Location: ' . URL . 'index.php?p=admin&c=Image');
            exit;
        }

        $fileName = basename($filePath);
        if (unlink($filePath)) {
            $_SESSION['success_msg'] = '已删除：' . $fileName;
            $this->logOperation('image', 'delete', '删除图片：' . $fileName, 'image', $filePath);
        } else {
            $_SESSION['error_msg'] = '删除失败';
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Image' . (!empty(dirname($filePath)) ? '&path=' . urlencode(dirname($filePath)) : ''));
        exit;
    }
}
