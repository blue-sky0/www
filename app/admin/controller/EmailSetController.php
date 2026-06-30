<?php

namespace admin\controller;

class EmailSetController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('EmailSet');
        $this->assign("tableData", "");

        $model = new \admin\model\SettingsModel();
        $settings = [];
        foreach (['general', 'mail', 'third_party'] as $group) {
            $settings[$group] = $model->getGroup($group);
        }

        $this->assign('settings', $settings);
        $this->assign('activeSection', 'mail');
        $this->assign('testResult', $_SESSION['mail_test_result'] ?? null);
        unset($_SESSION['mail_test_result']);

        $this->display("mailsettings.php");
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
            exit;
        }
        $this->checkCsrf();

        $model = new \admin\model\SettingsModel();
        $settings = $_POST['settings'] ?? [];

        foreach ($settings as $group => $items) {
            foreach ($items as $key => $value) {
                $model->set($group, $key, is_string($value) ? trim($value) : $value);
            }
        }

        $_SESSION['success_msg'] = '邮件设置已保存';
        $this->logOperation('emailset', 'save', '保存邮件设置');

        header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
        exit;
    }

    public function testMail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
            exit;
        }
        $this->checkCsrf();

        $to = trim($_POST['test_email'] ?? '');
        if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = '请输入有效的测试邮箱地址';
            header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
            exit;
        }

        try {
            $mailer = new \admin\service\MailerService();
            if (!$mailer->isConfigured()) {
                $_SESSION['error_msg'] = '邮件服务未配置，请先填写SMTP信息';
                header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
                exit;
            }
            $result = $mailer->sendTest($to);
            if ($result) {
                $_SESSION['success_msg'] = "测试邮件已发送到 {$to}，请查收";
                $this->logOperation('emailset', 'test_mail', "发送测试邮件到 {$to}");
            } else {
                $_SESSION['error_msg'] = '邮件发送失败，请检查SMTP配置';
            }
        } catch (\Exception $e) {
            $_SESSION['error_msg'] = '邮件发送失败：' . $e->getMessage();
        }

        header('Location: ' . URL . 'index.php?p=admin&c=EmailSet');
        exit;
    }
}
