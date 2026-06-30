<?php
/**
 * 初始化默认管理员账号
 * 运行方式：php scripts/seed_admin.php
 *
 * 默认账号：admin
 * 默认密码：admin123
 * 请在生产环境修改密码！
 */

define('ACCESS', true);
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once ROOT_PATH . 'core/App.php';

try {
    // 手动初始化
    \core\App::start();

    $userModel = new \models\UserModel();

    if ($userModel->exists('admin')) {
        echo "管理员账号 'admin' 已存在，跳过创建。\n";
        exit(0);
    }

    $result = $userModel->register('admin', 'admin123', 1);
    if ($result) {
        echo "管理员账号创建成功！\n";
        echo "用户名：admin\n";
        echo "密码：admin123\n";
        echo "请及时修改密码！\n";
    } else {
        echo "管理员账号创建失败！\n";
        exit(1);
    }
} catch (\Throwable $e) {
    echo "错误：" . $e->getMessage() . "\n";
    exit(1);
}
