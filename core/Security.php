<?php

// 命名空间
namespace core;

/**
 * 安全工具类
 */
class Security
{
    /**
     * 生成 CSRF Token
     * @return string
     */
    public static function generateCsrfToken()
    {
        $length = (int)(getenv('CSRF_TOKEN_LENGTH') ?: 32);
        $token = bin2hex(random_bytes($length / 2));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    /**
     * 验证 CSRF Token
     * @param string $token
     * @return bool
     */
    public static function verifyCsrfToken($token)
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * 获取 CSRF Token（如果不存在则生成）
     * @return string
     */
    public static function getCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            return self::generateCsrfToken();
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * XSS 过滤
     * @param mixed $data
     * @return mixed
     */
    public static function xssClean($data)
    {
        if (is_array($data)) {
            return array_map([__CLASS__, 'xssClean'], $data);
        } else {
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * SQL 过滤（简单版本，建议使用预处理语句）
     * @param string $data
     * @return string
     */
    public static function sqlClean($data)
    {
        // 注意：这个方法只作为备用，强烈建议使用 PDO 预处理语句
        return addslashes($data);
    }

    /**
     * 验证输入
     * @param string $data
     * @param string $type (email, url, int, float, etc.)
     * @return bool
     */
    public static function validate($data, $type = 'text')
    {
        switch ($type) {
            case 'email':
                return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
            case 'url':
                return filter_var($data, FILTER_VALIDATE_URL) !== false;
            case 'int':
                return filter_var($data, FILTER_VALIDATE_INT) !== false;
            case 'float':
                return filter_var($data, FILTER_VALIDATE_FLOAT) !== false;
            case 'ip':
                return filter_var($data, FILTER_VALIDATE_IP) !== false;
            case 'alphanumeric':
                return preg_match('/^[a-zA-Z0-9]+$/', $data);
            case 'text':
            default:
                return !empty(trim($data));
        }
    }

    /**
     * 防止目录遍历攻击
     * @param string $path
     * @return string
     */
    public static function sanitizePath($path)
    {
        // 移除 ../ 和类似的安全风险
        return str_replace(['..', "\0"], '', $path);
    }
}
