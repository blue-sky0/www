<?php

namespace admin\service;

class SecurityAuditService
{
    private $rootDir;
    private $results = [];
    private $score = 100;

    const SEVERITY_CRITICAL = 'critical';
    const SEVERITY_HIGH     = 'high';
    const SEVERITY_MEDIUM   = 'medium';
    const SEVERITY_LOW      = 'low';
    const SEVERITY_INFO     = 'info';

    public function __construct()
    {
        $this->rootDir = dirname(dirname(dirname(__DIR__)));
    }

    public function runFullAudit(): array
    {
        $this->results = [];
        $this->score = 100;

        $this->auditFilePermissions();
        $this->auditPasswordPolicy();
        $this->auditSecurityHeaders();
        $this->auditCsrfProtection();
        $this->auditSqlInjection();
        $this->auditSessionSecurity();
        $this->auditServerInfo();
        $this->auditFileUpload();
        $this->auditSensitiveFiles();

        return $this->generateReport();
    }

    private function auditFilePermissions(): void
    {
        $checks = [
            '.env' => ['severity' => self::SEVERITY_CRITICAL, 'desc' => '环境配置文件暴露', 'fix' => '将 .env 权限设为 600 或移出 Web 根目录'],
            'backups/' => ['severity' => self::SEVERITY_HIGH, 'desc' => '备份目录可公开访问', 'fix' => '在 .htaccess 中 Deny from all，或移出 Web 根目录'],
            'config/' => ['severity' => self::SEVERITY_HIGH, 'desc' => '配置目录暴露', 'fix' => '添加 .htaccess 或移出 Web 根目录'],
        ];

        $webRoot = realpath($this->rootDir . '/public');
        foreach ($checks as $name => $check) {
            $path = $this->rootDir . '/' . $name;
            if (file_exists($path)) {
                $realPath = realpath($path);
                if ($webRoot && $realPath && strpos($realPath, $webRoot) === 0) {
                    $this->addIssue($check['severity'], $check['desc'] . " ({$name})", $check['fix']);
                } else {
                    $this->addIssue(self::SEVERITY_INFO, "{$name} 在 Web 根目录外", '无需处理');
                }
            }
        }
    }

    private function auditPasswordPolicy(): void
    {
        $authFiles = [
            $this->rootDir . '/app/admin/controller/AuthController.php',
        ];

        $usePasswordHash = false;
        foreach ($authFiles as $file) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                if (strpos($content, 'password_hash') !== false || strpos($content, 'password_verify') !== false) {
                    $usePasswordHash = true;
                    break;
                }
            }
        }

        if (!$usePasswordHash) {
            $this->addIssue(self::SEVERITY_CRITICAL, '未使用 password_hash() 加密密码', '使用 password_hash() 替代 md5/sha1');
        }

        $this->addIssue(self::SEVERITY_INFO, '建议设置密码复杂度策略', '至少 8 位，包含字母和数字');
    }

    private function auditSecurityHeaders(): void
    {
        $headers = [];
        if (function_exists('headers_list')) {
            $headers = headers_list();
        }

        $headerMap = [];
        foreach ($headers as $h) {
            $parts = explode(':', $h, 2);
            if (count($parts) === 2) {
                $headerMap[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
        }

        $securityHeaders = [
            'X-Content-Type-Options' => ['expected' => 'nosniff', 'severity' => self::SEVERITY_MEDIUM, 'desc' => '缺少 X-Content-Type-Options', 'fix' => "header('X-Content-Type-Options: nosniff')"],
            'X-Frame-Options'        => ['expected' => 'SAMEORIGIN', 'severity' => self::SEVERITY_MEDIUM, 'desc' => '缺少 X-Frame-Options', 'fix' => "header('X-Frame-Options: SAMEORIGIN')"],
            'X-XSS-Protection'       => ['expected' => '1; mode=block', 'severity' => self::SEVERITY_LOW, 'desc' => '缺少 X-XSS-Protection', 'fix' => "header('X-XSS-Protection: 1; mode=block')"],
            'Referrer-Policy'        => ['expected' => 'strict-origin-when-cross-origin', 'severity' => self::SEVERITY_LOW, 'desc' => '缺少 Referrer-Policy', 'fix' => "header('Referrer-Policy: strict-origin-when-cross-origin')"],
        ];

        foreach ($securityHeaders as $name => $config) {
            $key = strtolower($name);
            if (!isset($headerMap[$key]) || $headerMap[$key] !== $config['expected']) {
                $current = isset($headerMap[$key]) ? $headerMap[$key] : '未设置';
                $this->addIssue($config['severity'], $config['desc'] . "（当前: {$current}）", $config['fix']);
            }
        }
    }

    private function auditCsrfProtection(): void
    {
        $controllerFiles = [
            $this->rootDir . '/app/admin/controller/BaseController.php',
        ];

        $hasCsrfToken = false;
        $hasCsrfCheck = false;

        foreach ($controllerFiles as $file) {
            if (!file_exists($file)) continue;
            $content = file_get_contents($file);
            if (strpos($content, 'csrf_token') !== false) $hasCsrfToken = true;
            if (strpos($content, 'checkCsrf') !== false) $hasCsrfCheck = true;
        }

        if (!$hasCsrfToken) {
            $this->addIssue(self::SEVERITY_CRITICAL, '未实现 CSRF Token 生成', '在表单中生成并验证 CSRF Token');
        } elseif (!$hasCsrfCheck) {
            $this->addIssue(self::SEVERITY_HIGH, '未实现 CSRF Token 验证', 'POST 请求检查 CSRF Token');
        } else {
            $this->addIssue(self::SEVERITY_INFO, 'CSRF 防护已实现', '确认所有 POST 表单都包含 csrf_token');
        }
    }

    private function auditSqlInjection(): void
    {
        $modelFile = $this->rootDir . '/core/Model.php';
        if (file_exists($modelFile)) {
            $content = file_get_contents($modelFile);
            if (strpos($content, 'prepare') !== false && strpos($content, 'bindParam') !== false) {
                $this->addIssue(self::SEVERITY_INFO, 'Model 使用预处理语句', '确认所有查询都使用参数化查询');
            } else {
                $this->addIssue(self::SEVERITY_CRITICAL, 'Model 未使用预处理语句', '必须使用 PDO prepare+bindParam 防止 SQL 注入');
            }
        }

        $controllerDir = $this->rootDir . '/app/';
        if (is_dir($controllerDir)) {
            $unsafePatterns = [];
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($controllerDir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->getExtension() !== 'php') continue;
                $content = file_get_contents($file->getPathname());
                if (preg_match('/\$sql\s*\.=\s*[\'"][^;\']*(?:WHERE|SET|VALUES)[^;\']*[\'"]\s*\.\s*\$_(GET|POST|REQUEST)/i', $content)) {
                    $unsafePatterns[] = $file->getFilename();
                }
            }

            if (!empty($unsafePatterns)) {
                $this->addIssue(self::SEVERITY_CRITICAL, "发现可能的 SQL 注入: " . implode(', ', $unsafePatterns), '检查所有变量拼接的 SQL，使用参数化查询替换');
            }
        }
    }

    private function auditSessionSecurity(): void
    {
        $httponly = ini_get('session.cookie_httponly');
        if (!$httponly) {
            $this->addIssue(self::SEVERITY_MEDIUM, 'Session Cookie 未设置 HttpOnly', 'session.cookie_httponly=1');
        }

        $authFiles = [
            $this->rootDir . '/app/admin/controller/AuthController.php',
        ];

        $hasRegenId = false;
        foreach ($authFiles as $file) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                if (strpos($content, 'session_regenerate_id') !== false) {
                    $hasRegenId = true;
                    break;
                }
            }
        }

        if (!$hasRegenId) {
            $this->addIssue(self::SEVERITY_HIGH, '登录后未重生 Session ID', '登录成功后调用 session_regenerate_id(true) 防止会话固定');
        }
    }

    private function auditServerInfo(): void
    {
        $exposePhp = ini_get('expose_php');
        if ($exposePhp) {
            $this->addIssue(self::SEVERITY_LOW, 'expose_php 已启用', 'php.ini: expose_php=Off');
        }
    }

    private function auditFileUpload(): void
    {
        $uploadDirs = [
            $this->rootDir . '/public/uploads/',
            $this->rootDir . '/uploads/',
        ];

        foreach ($uploadDirs as $dir) {
            if (is_dir($dir)) {
                if (!file_exists($dir . '/.htaccess')) {
                    $this->addIssue(self::SEVERITY_HIGH, "上传目录缺少安全防护: {$dir}", '添加 .htaccess 限制 PHP 执行');
                }
            }
        }

        $controllerFiles = glob($this->rootDir . '/app/admin/controller/*.php');
        $hasUploadValidation = false;

        foreach ($controllerFiles as $file) {
            $content = file_get_contents($file);
            if (strpos($content, 'mime_content_type') !== false ||
                strpos($content, 'finfo_file') !== false ||
                strpos($content, 'getimagesize') !== false) {
                $hasUploadValidation = true;
                break;
            }
        }

        if (!$hasUploadValidation) {
            $this->addIssue(self::SEVERITY_MEDIUM, '文件上传未检测 MIME 类型', '使用 mime_content_type 或 finfo 验证文件真实类型');
        }
    }

    private function auditSensitiveFiles(): void
    {
        $sensitiveFiles = [
            '.git/config', '.svn/entries', 'config.php', 'database.php',
            'phpinfo.php', 'info.php', 'test.php', 'admin.php',
            'composer.json', 'composer.lock', 'package.json',
            'README.md',
        ];

        $publicDir = $this->rootDir . '/public/';
        foreach ($sensitiveFiles as $file) {
            $path = $publicDir . $file;
            if (file_exists($path)) {
                $this->addIssue(
                    in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['json', 'md', 'lock'])
                        ? self::SEVERITY_LOW : self::SEVERITY_HIGH,
                    "敏感文件暴露: {$file}", '删除或移出 Web 根目录'
                );
            }
        }

        $gitDir = realpath($this->rootDir . '/.git');
        if ($gitDir && is_dir($gitDir) && strpos($gitDir, $publicDir) === 0) {
            $this->addIssue(self::SEVERITY_CRITICAL, '.git 目录暴露在 Web 根目录', '配置 Nginx/Apache 禁止访问 .git 目录');
        }
    }

    private function generateReport(): array
    {
        $bySeverity = [
            self::SEVERITY_CRITICAL => [],
            self::SEVERITY_HIGH     => [],
            self::SEVERITY_MEDIUM   => [],
            self::SEVERITY_LOW      => [],
            self::SEVERITY_INFO     => [],
        ];

        foreach ($this->results as $issue) {
            $bySeverity[$issue['severity']][] = $issue;
        }

        $deductions = [
            self::SEVERITY_CRITICAL => 15,
            self::SEVERITY_HIGH     => 8,
            self::SEVERITY_MEDIUM   => 4,
            self::SEVERITY_LOW      => 2,
            self::SEVERITY_INFO     => 0,
        ];

        foreach ($this->results as $issue) {
            $this->score -= $deductions[$issue['severity']] ?? 0;
        }
        $this->score = max(0, min(100, $this->score));

        $severityCounts = [];
        foreach ($bySeverity as $sev => $items) {
            $severityCounts[$sev] = count($items);
        }

        return [
            'score'           => $this->score,
            'grade'           => $this->score >= 90 ? 'A (优秀)' : ($this->score >= 75 ? 'B (良好)' : ($this->score >= 50 ? 'C (一般)' : 'D (危险)')),
            'total_issues'    => count($this->results),
            'severity_counts' => $severityCounts,
            'results'         => $this->results,
            'by_severity'     => $bySeverity,
            'report_time'     => date('Y-m-d H:i:s'),
            'summary'         => $this->generateSummary($severityCounts),
        ];
    }

    private function generateSummary(array $counts): string
    {
        $summary = "安全审计完成。";
        if ($counts[self::SEVERITY_CRITICAL] > 0) {
            $summary .= " 紧急: {$counts[self::SEVERITY_CRITICAL]}项";
        }
        if ($counts[self::SEVERITY_HIGH] > 0) {
            $summary .= " 高危: {$counts[self::SEVERITY_HIGH]}项";
        }
        if ($counts[self::SEVERITY_MEDIUM] > 0) {
            $summary .= " 中危: {$counts[self::SEVERITY_MEDIUM]}项";
        }
        if ($counts[self::SEVERITY_LOW] > 0) {
            $summary .= " 低危: {$counts[self::SEVERITY_LOW]}项";
        }
        $summary .= " 综合评分: {$this->score} 分";
        return $summary;
    }

    private function addIssue(string $severity, string $description, string $suggestion, string $detail = ''): void
    {
        $this->results[] = [
            'id'          => 'SEC-' . str_pad(count($this->results) + 1, 3, '0', STR_PAD_LEFT),
            'severity'    => $severity,
            'description' => $description,
            'suggestion'  => $suggestion,
            'detail'      => $detail,
            'category'    => $this->categorize($description),
        ];
    }

    private function categorize(string $desc): string
    {
        if (stripos($desc, 'XSS') !== false) return 'XSS 跨站脚本';
        if (stripos($desc, 'SQL') !== false) return 'SQL 注入';
        if (stripos($desc, 'CSRF') !== false) return 'CSRF 跨站请求伪造';
        if (stripos($desc, 'Session') !== false || stripos($desc, 'session') !== false) return 'Session 安全';
        if (stripos($desc, '密码') !== false || stripos($desc, 'password') !== false) return '密码安全';
        if (stripos($desc, '上传') !== false || stripos($desc, 'upload') !== false) return '文件上传安全';
        if (stripos($desc, '暴露') !== false) return '信息泄露';
        if (stripos($desc, '头部') !== false || stripos($desc, 'header') !== false) return 'HTTP 安全头部';
        if (stripos($desc, '权限') !== false) return '文件权限';
        return '其他';
    }
}
