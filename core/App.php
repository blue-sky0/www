<?php

namespace core;

if (!defined('ACCESS')) {
    header('location:../public/index.php');
    exit;
}

/**
 * WWW 框架核心入口类
 *
 * 负责：
 * - 目录常量定义
 * - 环境配置加载 (.env / config.php)
 * - URL 路由解析 (p/c/a 参数)
 * - PSR-4 风格自动加载注册
 * - Session 安全初始化
 * - 错误/异常处理器注册
 * - 分发到对应控制器方法
 */
class App
{
    /**
     * 应用入口：按顺序执行初始化流程
     */
    public static function start()
    {
        //目录常量设置
        self::set_path();
        // 提前加载 .env（错误处理需要读取 APP_DEBUG）
        self::loadEnv();
        //配置文件
        self::set_config();
        //错误处理
        self::set_error();
        //解析URL
        self::set_url();
        //自动加载
        self::set_autoload();
        //初始化会话
        self::set_session();
        //分发控制器
        self::set_dispatch();

    }

    /**
     * 初始化 Session
     *
     * 配置 httponly、samesite=Lax 等安全选项。
     * CLI 模式下跳过 Session 初始化。
     */
    private static function set_session()
    {
        if (php_sapi_name() === 'cli') {
            return;
        }
        if (session_status() === PHP_SESSION_NONE) {
            $lifetime = (int)(getenv('SESSION_LIFETIME') ?: 7200);
            $samesite = getenv('SESSION_COOKIE_SAMESITE') ?: 'Lax';

            ini_set('session.gc_maxlifetime', $lifetime);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);

            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => true,
                'samesite' => $samesite,
            ]);

            session_start();
        }
    }

    /**
     * 定义目录常量和网站根 URL
     */
    private static function set_path()
    {
        //定义不同路径常量：核心目录、App目录、控制器目录、模型目录、视图目录、扩展目录
        define('CORE_PATH', ROOT_PATH . 'core/');					// 核心目录
        define('APP_PATH', ROOT_PATH . 'app/');						// 应用目录
        define('HOME_PATH', APP_PATH . 'home/');					// 前台目录
        define('ADMIN_PATH', APP_PATH . 'admin/');					// 后台目录
        define('SHARED_PATH', APP_PATH . 'models/');				// 共享模型目录
        define('ADMIN_CONT', ADMIN_PATH . 'controller/');	  		// 后台控制器目录
        define('ADMIN_MODEL', ADMIN_PATH . 'model/');				// 后台模型目录
        define('ADMIN_VIEW', ADMIN_PATH . 'view/');			  		// 后台视图目录
        define('HOME_CONT', HOME_PATH . 'controller/');				// 前台控制器目录
        define('HOME_MODEL', HOME_PATH . 'model/');					// 前台模型目录
        define('HOME_VIEW', HOME_PATH . 'view/');					// 前台视图目录
        define('VENDOR_PATH', ROOT_PATH . 'vendor/');          		// 第三方类库目录
        define('CONFIG_PATH', ROOT_PATH . 'config/');				// 配置文件目录
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        define('URL', $protocol . $host . '/');				// 网站根URL
        //如果框架设计够大够全，还有一些目录常量需要配置
    }

    /**
     * 注册错误和异常处理器
     *
     * 根据 APP_DEBUG 环境变量决定是否显示详细错误信息。
     * 生产环境关闭 display_errors 防止敏感信息泄露。
     */
    private static function set_error()
    {
        //拿配置文件读取的全局变量
        global $config;

        // 从环境变量读取调试模式，默认为关闭
        $debugMode = getenv('APP_DEBUG') ? strtolower(getenv('APP_DEBUG')) : 'false';

        $errorReporting = ($debugMode === 'true' || $debugMode === '1') ? (E_ALL & ~E_DEPRECATED) : 0;
        $displayErrors = ($debugMode === 'true' || $debugMode === '1') ? 1 : 0;

        error_reporting($errorReporting);
        ini_set('display_errors', $displayErrors);

        // 定义调试模式常量
        define('APP_DEBUG', ($debugMode === 'true' || $debugMode === '1'));

        // 注册错误处理器
        if (APP_DEBUG) {
            set_error_handler([__CLASS__, 'errorHandler']);
            set_exception_handler([__CLASS__, 'exceptionHandler']);
        }
    }

    /**
     * 加载 config.php 配置文件到全局变量 $config
     */
    private static function set_config()
    {
        self::loadEnv();

        global $config;
        $config = include CONFIG_PATH . 'config.php';
    }

    /**
     * 解析 .env 文件并设置环境变量
     *
     * 支持 # 注释，自动去除引号，忽略空行。
     * 同时写入 putenv() 和 $_ENV。
     */
    private static function loadEnv()
    {
        $envFile = ROOT_PATH . '.env';
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            // 移除可能的引号
            $value = trim($value, '"\'');
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }

    /**
     * 解析 URL 参数并定义为常量
     *
     * 参数：
     * - p (platform): home/admin
     * - c (controller): 控制器名
     * - a (action): 方法名
     * - S: 后台侧边栏大类别
     * - page: 前台页类别
     * - f: 后台功能标识
     *
     * 所有参数经过安全过滤（只允许字母/数字/下划线）。
     */
    private static function set_url()
    {
        //取出平台信息（p），控制器信息（c）和具体方法信息（a）
        $p = $_REQUEST['p'] ?? 'home';	        // 默认访问前台
        $c = $_REQUEST['c'] ?? 'Index';	        // 默认IndexController
        $a = $_REQUEST['a'] ?? 'index';
        $s = $_REQUEST['S'] ?? '';              // 大类别
        $page = $_REQUEST['page'] ?? '';        // 前台页类别
        $f = $_REQUEST['f'] ?? '';              // 后台功能 增(increase) 删(delete) 改(change) 查(check)

        // 安全过滤：只允许字母、数字和下划线
        $p = preg_replace('/[^a-zA-Z]/', '', $p);
        $c = preg_replace('/[^a-zA-Z0-9]/', '', $c);
        $a = preg_replace('/[^a-zA-Z0-9_]/', '', $a);
        $f = preg_replace('/[^a-zA-Z]/', '', $f);

        // XSS 防护
        $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
        $page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');

        //考虑到以上信息可能会在后序用到（其他类中）：定义成常量
        define('P', $p);
        define('C', $c);
        define('A', $a);
        define('S', $s);
        define('Page', $page);
        define('F', $f);
    }

    /**
     * 自动加载回调函数（PSR-4 风格）
     *
     * 加载顺序：
     * 1. 命名空间映射（admin\constants, admin\service, admin\model 等）
     * 2. core 目录
     * 3. 当前平台 controller 目录
     * 4. 共享模型目录
     * 5. 当前平台 model 目录
     * 6. vendor 目录
     */
    private static function set_autoload_function($class)
    {
        $originalClass = $class;

        //命名空间类加载：admin\constants\*, admin\service\*, admin\model\*, models\*
        $nsPaths = [
            'admin\\constants\\' => ADMIN_PATH . 'constants/',
            'admin\\service\\'   => ADMIN_PATH . 'service/',
            'admin\\model\\'     => ADMIN_MODEL,
            'models\\'           => SHARED_PATH,
            'admin\\controller\\' => ADMIN_CONT,
            'home\\controller\\'  => HOME_CONT,
        ];
        foreach ($nsPaths as $prefix => $baseDir) {
            if (strpos($originalClass, $prefix) === 0) {
                $relativeClass = substr($originalClass, strlen($prefix));
                $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
                if (file_exists($file)) {
                    include $file;
                    return;
                }
            }
        }

        //$class代表内存中不存在的类（如果项目有命名空间，那么此时带着空间路径）\home\controller\IndexController
        //取出类名
        // echo PHP_OS.'<br/>';
        if (strpos(PHP_OS, 'WIN') === 0) {
            $class = basename($class);								# windows
        } elseif (strpos(PHP_OS, 'Linux') === 0) {
            $class = basename(str_replace('\\', '/', $class));  	# linux
        }
        // echo $class.'<br/>';
        //判定对应文件夹是否存在：存在包含
        $core_file = CORE_PATH . $class . '.php';
        // echo $core_file.'<br/>';
        if (file_exists($core_file)) {
            include $core_file;
        }

        //判定控制器是否存在：包括前后台的
        $cont_file = APP_PATH . P . '/controller/' . $class . '.php';
        // echo $cont_file.'<br/>';
        if (file_exists($cont_file)) {
            include $cont_file;
        }

        //判定共享模型是否存在
        $model_file = SHARED_PATH. $class . '.php';
        // echo $model_file.'<br/>';
        if (file_exists($model_file)) {
            include $model_file;
        }

        //判定模型是否存在
        $model_file = APP_PATH . P . '/model/' . $class . '.php';
        // echo $model_file.'<br/>';
        if (file_exists($model_file)) {
            include $model_file;
        }

        //插件加载
        $vendor_file = VENDOR_PATH . $class . '.php';
        // echo $vendor_file.'<br/>';
        if (file_exists($vendor_file)) {
            include $vendor_file;
        }
    }

    /**
     * 注册自动加载函数到 SPL 栈
     */
    private static function set_autoload()
    {
        //利用spl_autoload_register进行注册
        spl_autoload_register(array(__CLASS__,'set_autoload_function'));
    }

    /**
     * 自定义错误处理器
     *
     * E_DEPRECATED 级别错误静默忽略，其余错误写入日志。
     * APP_DEBUG 模式下显示详细错误信息。
     */
    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
            return true;
        }

        if (!(error_reporting() & $errno)) {
            return true;
        }

        self::logError("[$errno] $errstr in $errfile on line $errline");

        if (APP_DEBUG) {
            echo "<b>Error:</b> [$errno] $errstr<br/>";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br/>";
            echo "Aborting...<br/>";
        }

        return true;
    }

    /**
     * 自定义未捕获异常处理器
     */
    public static function exceptionHandler($exception)
    {
        self::logError("Uncaught exception: " . $exception->getMessage());

        if (APP_DEBUG) {
            echo "<b>Exception:</b> " . $exception->getMessage() . "<br/>";
            echo "  in " . $exception->getFile() . " on line " . $exception->getLine() . "<br/>";
        }
    }

    /**
     * 写入错误日志到 logs/ 目录
     */
    private static function logError($message)
    {
        $logDir = ROOT_PATH . 'logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . '/error_' . date('Y-m-d') . '.log';
        $logMessage = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
    }


    /**
     * 分发请求到对应控制器方法
     *
     * 根据 URL 参数 p/c/a 实例化控制器并调用方法。
     * 验证平台合法性、控制器和方法是否存在。
     */
    private static function set_dispatch()
    {
        //找打前后台、控制器、方法：\home\controller\IndexController;
        $p = P;
        $c = C;
        $a = A;

        // 验证平台名称
        if (!in_array($p, ['home', 'admin'])) {
            self::errorHandler(E_USER_ERROR, '非法的平台参数', __FILE__, __LINE__);
            die('非法的请求');
        }

        //组织成合适的空间元素（首字母大写以确保类名匹配）
        $controller = "\\{$p}\\controller\\" . ucfirst($c) . "Controller";

        // 检查控制器类是否存在
        if (!class_exists($controller)) {
            if (APP_DEBUG) {
                self::errorHandler(E_USER_ERROR, "控制器不存在: {$controller}", __FILE__, __LINE__);
            }
            die('页面不存在');
        }

        $c = new $controller();								//已经拿到对象：调用方法

        // 检查方法是否存在
        if (!method_exists($c, $a)) {
            if (APP_DEBUG) {
                self::errorHandler(E_USER_ERROR, "方法不存在: {$a}", __FILE__, __LINE__);
            }
            die('页面不存在');
        }

        //调用方法：最终分发
        $c->$a();											//可变方法

    }
}
