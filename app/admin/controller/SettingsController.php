<?php

namespace admin\controller;

class SettingsController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Settings');

        $model = new \admin\model\SettingsModel();
        $settings = [];
        foreach (['general', 'mail', 'third_party'] as $group) {
            $settings[$group] = $model->getGroup($group);
        }

        $activeSection = $_GET['section'] ?? 'general';
        if (!in_array($activeSection, ['general', 'mail', 'third_party'])) {
            $activeSection = 'general';
        }

        $this->assign('settings', $settings);
        $this->assign('activeSection', $activeSection);
        $this->assign("tableData", "");

        $this->display("settings.php");
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Settings');
            exit;
        }
        $this->checkCsrf();

        $model = new \admin\model\SettingsModel();
        $settings = $_POST['settings'] ?? [];
        $section = $_POST['section'] ?? 'general';

        foreach ($settings as $group => $items) {
            foreach ($items as $key => $value) {
                $model->set($group, $key, is_string($value) ? trim($value) : $value);
            }
        }

        $_SESSION['success_msg'] = '设置已保存';
        $this->logOperation('settings', 'save', '保存系统设置：' . $section, 'settings', null);

        header('Location: ' . URL . 'index.php?p=admin&c=Settings&section=' . urlencode($section));
        exit;
    }

    public function clearCache()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Settings');
            exit;
        }
        $this->checkCsrf();

        $compileDirs = [
            dirname(dirname(dirname(__DIR__))) . '/app/admin/template_c',
            dirname(dirname(dirname(__DIR__))) . '/app/home/template_c',
        ];

        $cleared = 0;
        foreach ($compileDirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . '/*.php');
                foreach ($files as $file) {
                    if (is_file($file) && unlink($file)) {
                        $cleared++;
                    }
                }
            }
        }

        $_SESSION['success_msg'] = "已清除 {$cleared} 个缓存文件";
        $this->logOperation('settings', 'clear_cache', '清除模板缓存，共' . $cleared . '个文件');

        header('Location: ' . URL . 'index.php?p=admin&c=Settings');
        exit;
    }

    public function testMail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=Settings&section=mail');
            exit;
        }
        $this->checkCsrf();

        $to = trim($_POST['test_email'] ?? '');
        if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = '请输入有效的测试邮箱地址';
            header('Location: ' . URL . 'index.php?p=admin&c=Settings&section=mail');
            exit;
        }

        try {
            $mailer = new \admin\service\MailerService();
            if (!$mailer->isConfigured()) {
                $_SESSION['error_msg'] = '邮件服务未配置，请先填写SMTP信息';
                header('Location: ' . URL . 'index.php?p=admin&c=Settings&section=mail');
                exit;
            }
            $result = $mailer->sendTest($to);
            if ($result) {
                $_SESSION['success_msg'] = "测试邮件已发送到 {$to}，请查收";
                $this->logOperation('settings', 'test_mail', "发送测试邮件到 {$to}");
            } else {
                $_SESSION['error_msg'] = '邮件发送失败，请检查SMTP配置';
            }
        } catch (\Exception $e) {
            $_SESSION['error_msg'] = '邮件发送失败：' . $e->getMessage();
        }

        header('Location: ' . URL . 'index.php?p=admin&c=Settings&section=mail');
        exit;
    }
}
