<?php

namespace admin\constants;

class Permissions
{
    const PERMISSION_ALL = '*';

    const DASHBOARD_VIEW = 'dashboard.view';

    const CONTENT_ARTICLE_VIEW = 'content.article.view';
    const CONTENT_ARTICLE_CREATE = 'content.article.create';
    const CONTENT_ARTICLE_EDIT = 'content.article.edit';
    const CONTENT_ARTICLE_DELETE = 'content.article.delete';

    const CONTENT_IMAGE_VIEW = 'content.image.view';
    const CONTENT_IMAGE_UPLOAD = 'content.image.upload';
    const CONTENT_IMAGE_DELETE = 'content.image.delete';

    const CONTENT_VIDEO_VIEW = 'content.video.view';
    const CONTENT_VIDEO_UPLOAD = 'content.video.upload';
    const CONTENT_VIDEO_DELETE = 'content.video.delete';

    const USER_VIEW = 'user.view';
    const USER_CREATE = 'user.create';
    const USER_EDIT = 'user.edit';
    const USER_DELETE = 'user.delete';

    const ROLE_VIEW = 'role.view';
    const ROLE_CREATE = 'role.create';
    const ROLE_EDIT = 'role.edit';
    const ROLE_DELETE = 'role.delete';
    const ROLE_ASSIGN = 'role.assign';

    const SETTINGS_VIEW = 'settings.view';
    const SETTINGS_EDIT = 'settings.edit';

    const LOG_VIEW = 'log.view';
    const LOG_CLEAN = 'log.clean';
    const LOG_EXPORT = 'log.export';

    const DATA_VIEW = 'data.view';

    const ONLINE_VIEW = 'online.view';
    const ONLINE_KICK = 'online.kick';
    const ONLINE_HISTORY = 'online.history';

    const BACKUP_VIEW = 'backup.view';
    const BACKUP_CREATE = 'backup.create';
    const BACKUP_RESTORE = 'backup.restore';
    const BACKUP_DOWNLOAD = 'backup.download';
    const BACKUP_DELETE = 'backup.delete';

    const ANALYSIS_VIEW = 'analysis.view';
    const ANALYSIS_EXPORT = 'analysis.export';

    const CACHE_VIEW = 'cache.view';
    const CACHE_CLEAR = 'cache.clear';

    const OPTIMIZE_VIEW = 'optimize.view';
    const OPTIMIZE_DB = 'optimize.db';
    const OPTIMIZE_CACHE = 'optimize.cache';

    const SECURITY_AUDIT = 'security.audit';

    const DATA_IE = 'data.ie';
    const DATA_IE_EXPORT = 'data.ie.export';
    const DATA_IE_IMPORT = 'data.ie.import';
    const DATA_IE_CLEAR = 'data.ie.clear';

    private static $labels = [];

    public static function init()
    {
        self::$labels = [
            self::DASHBOARD_VIEW => '仪表盘',

            self::CONTENT_ARTICLE_VIEW => '查看文章列表',
            self::CONTENT_ARTICLE_CREATE => '创建文章',
            self::CONTENT_ARTICLE_EDIT => '编辑文章',
            self::CONTENT_ARTICLE_DELETE => '删除文章',

            self::CONTENT_IMAGE_VIEW => '查看图片',
            self::CONTENT_IMAGE_UPLOAD => '上传图片',
            self::CONTENT_IMAGE_DELETE => '删除图片',

            self::CONTENT_VIDEO_VIEW => '查看视频',
            self::CONTENT_VIDEO_UPLOAD => '上传视频',
            self::CONTENT_VIDEO_DELETE => '删除视频',

            self::USER_VIEW => '查看用户',
            self::USER_CREATE => '创建用户',
            self::USER_EDIT => '编辑用户',
            self::USER_DELETE => '删除用户',

            self::ROLE_VIEW => '查看角色',
            self::ROLE_CREATE => '创建角色',
            self::ROLE_EDIT => '编辑角色',
            self::ROLE_DELETE => '删除角色',
            self::ROLE_ASSIGN => '分配角色',

            self::SETTINGS_VIEW => '查看设置',
            self::SETTINGS_EDIT => '编辑设置',

            self::LOG_VIEW => '查看日志',
            self::LOG_CLEAN => '清理日志',
            self::LOG_EXPORT => '导出日志',

            self::DATA_VIEW => '查看数据',

            self::ONLINE_VIEW => '查看在线用户',
            self::ONLINE_KICK => '踢出用户',
            self::ONLINE_HISTORY => '查看登录历史',

            self::BACKUP_VIEW => '查看备份',
            self::BACKUP_CREATE => '创建备份',
            self::BACKUP_RESTORE => '恢复备份',
            self::BACKUP_DOWNLOAD => '下载备份',
            self::BACKUP_DELETE => '删除备份',

            self::ANALYSIS_VIEW => '查看行为分析',
            self::ANALYSIS_EXPORT => '导出分析数据',

            self::CACHE_VIEW => '查看缓存管理',
            self::CACHE_CLEAR => '清理缓存',

            self::OPTIMIZE_VIEW => '查看优化工具',
            self::OPTIMIZE_DB => '优化数据库',
            self::OPTIMIZE_CACHE => '清理 PHP 缓存',

            self::SECURITY_AUDIT => '执行安全审计',

            self::DATA_IE => '数据导入导出',
            self::DATA_IE_EXPORT => '导出数据',
            self::DATA_IE_IMPORT => '导入数据',
            self::DATA_IE_CLEAR => '清空表',
        ];
    }

    public static function getLabel($permission)
    {
        if (empty(self::$labels)) {
            self::init();
        }
        return self::$labels[$permission] ?? $permission;
    }

    public static function getAll()
    {
        if (empty(self::$labels)) {
            self::init();
        }
        $ref = new \ReflectionClass(self::class);
        $permissions = [];
        foreach ($ref->getConstants() as $name => $value) {
            if ($name === 'PERMISSION_ALL') continue;
            if (strpos($value, '.') === false) continue;
            $permissions[] = $value;
        }
        return $permissions;
    }

    public static function getGrouped()
    {
        if (empty(self::$labels)) {
            self::init();
        }
        $groups = [];
        foreach (self::getAll() as $perm) {
            $parts = explode('.', $perm, 2);
            $group = $parts[0] ?? 'other';
            $groups[$group][] = $perm;
        }
        return $groups;
    }
}
