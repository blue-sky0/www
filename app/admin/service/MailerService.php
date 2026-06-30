<?php

namespace admin\service;

class MailerService
{
    private $host;
    private $port;
    private $user;
    private $pass;
    private $encryption;
    private $fromEmail;
    private $fromName;

    public function __construct()
    {
        $model = new \admin\model\SettingsModel();
        $mailSettings = $model->getGroup('mail');
        $settings = [];
        foreach ($mailSettings as $s) {
            $settings[$s['key_name']] = $s['value'];
        }

        $this->host = $settings['smtp_host'] ?? '';
        $this->port = (int)($settings['smtp_port'] ?? 25);
        $this->user = $settings['smtp_user'] ?? '';
        $this->pass = $settings['smtp_pass'] ?? '';
        $this->encryption = $settings['smtp_encryption'] ?? '';
        $this->fromEmail = $settings['from_email'] ?? '';
        $this->fromName = $settings['from_name'] ?? '系统通知';
    }

    public function isConfigured()
    {
        return !empty($this->host) && !empty($this->port);
    }

    public function send($to, $subject, $body, $isHtml = true)
    {
        if (!$this->isConfigured()) {
            throw new \RuntimeException('邮件服务未配置');
        }

        $useSmtp = !empty($this->user);

        if ($useSmtp) {
            return $this->sendSmtp($to, $subject, $body, $isHtml);
        } else {
            return $this->sendMail($to, $subject, $body, $isHtml);
        }
    }

    public function sendTest($to)
    {
        $subject = '测试邮件 - 系统配置验证';
        $body = '<h2>邮件服务配置测试</h2>';
        $body .= '<p>如果您收到此邮件，说明系统邮件服务配置正确。</p>';
        $body .= '<p>发送时间：' . date('Y-m-d H:i:s') . '</p>';
        $body .= '<hr>';
        $body .= '<p style="color:#999;">此邮件由系统自动发送，请勿回复。</p>';

        return $this->send($to, $subject, $body);
    }

    private function sendMail($to, $subject, $body, $isHtml)
    {
        $headers = [];
        $headers[] = 'From: ' . $this->fromName . ' <' . $this->fromEmail . '>';
        $headers[] = 'Reply-To: ' . $this->fromEmail;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/' . ($isHtml ? 'html' : 'plain') . '; charset=utf-8';
        $headers[] = 'X-Mailer: PHP/' . phpversion();

        return mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("\r\n", $headers));
    }

    private function sendSmtp($to, $subject, $body, $isHtml)
    {
        $host = $this->host;
        $port = $this->port;
        $user = $this->user;
        $pass = $this->pass;
        $encryption = $this->encryption;
        $fromEmail = $this->fromEmail;
        $fromName = $this->fromName;

        $useTls = ($encryption === 'tls' && $port !== 465);
        $useSsl = ($encryption === 'ssl' || $port === 465);

        $protocol = $useSsl ? 'ssl://' : '';
        $remote = $protocol . $host;

        $errno = 0;
        $errstr = '';

        $socket = @fsockopen($remote, $port, $errno, $errstr, 30);
        if (!$socket) {
            throw new \RuntimeException("无法连接到SMTP服务器: $errstr ($errno)");
        }

        $response = $this->smtpGetResponse($socket);

        if (strpos($response, '220') !== 0) {
            fclose($socket);
            throw new \RuntimeException("SMTP服务器异常: $response");
        }

        $this->smtpSendCommand($socket, "EHLO localhost");

        if ($useTls) {
            $this->smtpSendCommand($socket, "STARTTLS");
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $this->smtpSendCommand($socket, "EHLO localhost");
        }

        if (!empty($user) && !empty($pass)) {
            $this->smtpSendCommand($socket, "AUTH LOGIN");
            $this->smtpSendCommand($socket, base64_encode($user));
            $this->smtpSendCommand($socket, base64_encode($pass));
        }

        $this->smtpSendCommand($socket, "MAIL FROM:<$fromEmail>");
        $this->smtpSendCommand($socket, "RCPT TO:<$to>");
        $this->smtpSendCommand($socket, "DATA");

        $headers = "From: $fromName <$fromEmail>\r\n";
        $headers .= "Reply-To: $fromEmail\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/" . ($isHtml ? 'html' : 'plain') . "; charset=utf-8\r\n";
        $headers .= "X-Mailer: PHP SMTP\r\n";
        $headers .= "Date: " . date('r') . "\r\n";

        $mimeSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $this->smtpSendCommand($socket, "Subject: $mimeSubject");
        fputs($socket, $headers . "\r\n");
        fputs($socket, $body . "\r\n");
        $this->smtpSendCommand($socket, ".");

        $this->smtpSendCommand($socket, "QUIT");
        fclose($socket);

        return true;
    }

    private function smtpSendCommand($socket, $command)
    {
        fputs($socket, $command . "\r\n");
        if (strtolower(substr($command, 0, 4)) === 'data' && strpos($command, "\n") !== false) {
            return;
        }
        $this->smtpGetResponse($socket);
    }

    private function smtpGetResponse($socket)
    {
        $response = '';
        while ($line = fgets($socket, 512)) {
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        return $response;
    }
}
