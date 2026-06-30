# WWW 后台管理系统

> 学习资源内容管理平台 · PHP MVC + Smarty

[![PHP Version](https://img.shields.io/badge/PHP-7.4+-blue.svg)](https://www.php.net/)
[![MySQL Version](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📖 项目简介

WWW 是一个基于 PHP MVC 架构的学习资源内容管理后台系统，支持课程分类管理、学科内容编辑、左侧导航维护、右侧正文管理，以及数据导入导出等完整功能。

> **Note:** 本项目原名 "W3School模仿站"，逐步演进为独立的学习资源管理平台。

---

## 🛠 技术栈

| 层级 | 技术 | 说明 |
|------|------|------|
| 后端 | PHP 7.4+ | 核心语言 |
| 框架 | 自定义 MVC | 轻量级框架（`core/`） |
| 模板引擎 | Smarty 3.1+ | 视图层渲染 |
| 数据库 | MySQL 8.0+ | 数据持久化 |
| 前端 | jQuery 3.x + Bootstrap 5 | 用户界面 |
| 图表 | Highcharts + ECharts | 数据可视化 |
| 图标 | Font Awesome 6 | UI图标库 |

---

## 📂 目录结构

```
www/
├── app/                          # 应用核心目录
│   ├── admin/                    # 后台管理模块
│   │   ├── controller/           # 控制器（22个后台控制器）
│   │   │   ├── IndexController.php    # 首页/仪表盘
│   │   │   ├── AuthController.php    # 登录认证
│   │   │   ├── UserAccountController.php  # 用户管理
│   │   │   ├── DataIEController.php   # 数据导入导出 ⚠️ 待完善
│   │   │   ├── DataBRController.php   # 数据备份恢复
│   │   │   ├── NavController.php      # 导航管理
│   │   │   ├── CourseController.php   # 课程管理
│   │   │   ├── SubjbectController.php  # 学科管理
│   │   │   ├── LeftMainTitleController.php  # 左侧主标题
│   │   │   ├── LeftSideSubtitleController.php  # 左侧副标题
│   │   │   ├── RightContentController.php  # 正文内容管理
│   │   │   ├── AdminController.php    # 后台管理员
│   │   │   ├── BackSystemController.php  # 后台系统配置
│   │   │   └── ...
│   │   ├── model/                # 数据模型
│   │   │   ├── BaseModel.php
│   │   │   ├── AllFunctionModel.php  # 通用分页/统计
│   │   │   ├── UserAccountModel.php
│   │   │   ├── NavModel.php
│   │   │   ├── CourseModel.php
│   │   │   ├── SubjbectModel.php
│   │   │   ├── LeftMainTitleModel.php
│   │   │   ├── LeftSideSubtitleModel.php
│   │   │   ├── RightContentModel.php
│   │   │   ├── AdminModel.php
│   │   │   ├── BackSystemModel.php
│   │   │   ├── LogModel.php
│   │   │   └── StatsModel.php    # 统计分析
│   │   ├── service/             # 业务逻辑层（8个服务类）
│   │   │   ├── AuthService.php   # 认证服务
│   │   │   ├── UserService.php
│   │   │   ├── ContentService.php
│   │   │   ├── NavigationService.php
│   │   │   ├── ExportService.php
│   │   │   ├── ImportService.php
│   │   │   ├── BackupService.php
│   │   │   └── ReportService.php
│   │   └── view/                # Smarty 模板视图
│   │       ├── header.php
│   │       ├── footer.php
│   │       ├── index.php        # 后台首页
│   │       ├── left_main_title.php
│   │       ├── left_side_subtitle.php
│   │       ├── right_content.php
│   │       └── ...
│   └── home/                    # 前台展示模块（TODO）
├── core/                         # 核心框架
│   ├── App.php                  # 入口/路由
│   ├── Controller.php           # 基础控制器
│   ├── Model.php               # 基础模型（PDO封装+预处理SQL）
│   ├── Dao.php                 # 数据访问对象
│   ├── Security.php           # 安全工具（XSS过滤等）
│   ├── Session.php             # 会话管理
│   ├── Cookie.php             # Cookie管理
│   └── BaseController.php     # 后台基础控制器（CSRF/权限）
├── config/                      # 配置文件
│   ├── config.php             # 主配置
│   └── .env                   # 环境变量（数据库等）
├── public/                     # Web根目录（公开访问）
│   ├── images/               # 图片资源
│   ├── css/                  # 样式文件
│   ├── js/                   # JavaScript文件
│   └── uploads/              # 上传文件目录 ⚠️ 需防护
├── backups/                   # 备份与方案文档
│   ├── tables.sql            # 数据库表结构完整导出
│   ├── S_*.sql              # 各表单独导出
│   ├── WWW项目完整审查文档.md  # 项目审查报告（B+评分）
│   ├── 网页导入内容智能分配方案.md  # 网络导入功能方案
│   ├── 后台首页仪表盘实现方案.md    # 仪表盘改造方案
│   └── 数据导入导出实现方案.md      # 数据导入导出方案
├── scripts/                   # 脚本
│   ├── migrate_fix_typo.sql  # ⚠️ 待执行：subjbect→subject 表名修正
│   └── ...
├── .htaccess                  # Apache URL重写
└── index.php                  # 入口文件
```

---

## 🗄️ 数据库设计

### ER 关系图

```
┌─────────────┐      1:N       ┌─────────────────┐
│  S_course   │ ────────────── │   S_subjbect    │
│  课程类别    │                │  (学科) ⚠️表名拼写错误 │
└─────────────┘                └────────┬────────┘
                                       │
                          ┌────────────┼────────────┐
                          │ 1:N         │ 1:N        │ 1:N
                          ↓            ↓            ↓
              ┌──────────────────┐  ┌──────────────────┐
              │ S_leftMainTitle  │  │ S_leftSideSubtitle│
              │  (左侧主标题)     │  │   (左侧副标题)    │
              └────────┬─────────┘  └────────┬─────────┘
                       │                     │ 1:1
                       │                     ↓
                       │           ┌──────────────────┐
                       └─────────► │  S_rightContent  │
                                   │   (正文内容)      │
                                   └──────────────────┘
```

### 表清单

| 表名 | 说明 | 记录数 |
|------|------|--------|
| `S_user` | 后台用户表 | - |
| `S_course` | 课程类别表 | - |
| `S_subjbect` | 学科表 ⚠️ | - |
| `S_leftMainTitle` | 左侧主标题表 | - |
| `S_leftSideSubtitle` | 左侧副标题表 | - |
| `S_rightContent` | 右侧正文内容表 | 460+ |
| `S_nav` | 前台导航栏表 | - |
| `S_backSystem` | 后台系统配置表 | - |
| `S_admin` | 后台管理员表 | - |
| `S_operation_logs` | 操作日志表 | - |

### ⚠️ 表名拼写错误

> `S_subjbect` 正确拼写应为 `S_subject`。需手动执行迁移脚本：
> ```bash
> mysql -u your_user -p your_database < scripts/migrate_fix_typo.sql
> ```

---

## ✨ 功能模块

### ✅ 已完成

| 模块 | 功能 | 状态 |
|------|------|------|
| 登录认证 | 用户登录、Session管理 | ✅ |
| 用户管理 | 增删改查、密码修改 | ✅ |
| 课程管理 | 课程类别 CRUD | ✅ |
| 学科管理 | 学科 CRUD | ✅ |
| 左侧主标题 | 主标题管理 | ✅ |
| 左侧副标题 | 副标题管理（含分页） | ✅ |
| 正文内容管理 | 富文本内容编辑 | ✅ |
| 导航管理 | 前台导航 CRUD | ✅ |
| 后台系统配置 | 后台菜单/图标管理 | ✅ |
| 数据备份恢复 | SQL文件导出/导入 | ✅ |
| 安全修复 | CSRF Token、SQL预处理、XSS过滤、Session固定防护 | ✅ |
| 性能优化 | 索引、分页、缓存策略 | ✅ |

### 🔧 待完善

| 模块 | 优先级 | 说明 |
|------|--------|------|
| 数据导入导出 | P1 | 当前 DataIEController 仅重定向，待实现完整功能 |
| 后台首页仪表盘 | P1 | 当前仅显示静态页面，待实现统计图表 |
| 网络导入内容 | P1 | 从URL抓取网页内容并智能分配到多表 |
| HTTP 安全头 | P1 | CSP、X-Frame-Options 等 |
| 操作日志完善 | P1 | 所有写操作需记录到日志表 |
| 密码加密升级 | P0 | 应使用 `password_hash()` |
| 登录失败锁定 | P2 | IP级别连续失败锁定 |

### 📋 规划中

| 模块 | 优先级 | 说明 |
|------|--------|------|
| 权限管理 (RBAC) | P2 | 角色+权限+AuthService |
| 邮件设置 | P2 | SMTP 原生发送 |
| 数据报表增强 | P2 | ECharts 集成 |
| 在线用户管理 | P3 | 实时在线用户追踪 |
| 数据备份恢复增强 | P3 | 自动备份+远程存储 |
| 用户行为分析 | P3 | 访问统计+热点分析 |
| 缓存管理 | P4 | Redis 缓存层 |
| 性能监控 | P4 | 慢查询日志 |
| 安全审计报告 | P4 | 自动安全扫描 |

---

## 🚀 快速开始

### 环境要求

- PHP 7.4+ (推荐 PHP 8.x)
- MySQL 8.0+
- Apache 或 Nginx
- PHP 扩展：`pdo_mysql`, `gd`, `mbstring`, `curl`, `openssl`

### 安装步骤

#### 1. 克隆项目

```bash
cd /var/www
git clone https://your-repo/www.git
cd www
```

#### 2. 配置数据库

```bash
# 创建数据库
mysql -u root -p
CREATE DATABASE study DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
EXIT;

# 导入表结构
mysql -u root -p study < backups/tables.sql

# 修正表名拼写（重要！）
mysql -u root -p study < scripts/migrate_fix_typo.sql
```

#### 3. 配置环境

编辑 `config/config.php`：

```php
return [
    'database' => [
        'host'     => 'localhost',
        'port'     => 3306,
        'dbname'   => 'study',
        'username' => 'your_db_user',
        'password' => 'your_db_password',
        'charset'  => 'utf8mb4',
        'prefix'   => 'S_'
    ],
    'app' => [
        'debug'   => false,  // ⚠️ 生产环境必须设为 false
        'name'    => 'WWW 后台管理',
        'charset' => 'UTF-8',
        'timezone'=> 'Asia/Shanghai'
    ],
    'security' => [
        'csrf_enable'     => true,
        'xss_filter'      => true,
        'session_regenerate' => true  // Session 固定防护
    ]
];
```

#### 4. Web 服务器配置

**Apache (.htaccess)**

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?p=$1 [QSA,L]

# 禁止访问敏感目录
<Directory "core">
    Order Allow,Deny
    Deny from all
</Directory>

# 上传目录禁止PHP执行（重要！）
<Directory "public/uploads">
    php_flag engine off
    RemoveHandler .php
    RemoveType .php
</Directory>
```

**Nginx**

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/www;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?p=$uri;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # 禁止访问敏感目录
    location ~ /core/ {
        deny all;
    }

    # 上传目录禁止PHP执行
    location ~ /public/uploads/.*\.php$ {
        deny all;
    }
}
```

#### 5. 设置权限

```bash
chown -R www-data:www-data /var/www/www
chmod -R 755 /var/www/www
chmod -R 775 public/uploads backups
```

#### 6. 访问后台

```
http://your-domain.com/?p=admin
默认账号: admin
默认密码: admin
```

> ⚠️ **首次登录后立即修改默认密码！**

---

## 🔐 安全配置

### 已实现的安全措施

| 措施 | 说明 | 状态 |
|------|------|------|
| CSRF Token | 所有POST表单自动验证 | ✅ |
| SQL预处理 | Model层全部使用参数化查询 | ✅ |
| XSS过滤 | Security类提供输入/输出过滤 | ✅ |
| Session固定防护 | 登录后再生session_id | ✅ |
| SameSite Cookie | Lax模式防CSRF | ✅ |
| 文件上传验证 | 类型/大小/MIME验证 | ✅ |
| URL白名单 | 网络导入防SSRF | ✅ |

### ⚠️ 待加强

```php
// 1. 密码哈希（修改 UserAccountModel.php）
// 现有：
$password = md5($_POST['password']);
// 应改为：
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// 2. HTTP 安全头（在入口文件添加）
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Strict-Transport-Security: max-age=31536000');

// 3. 上传目录 .htaccess（创建 public/uploads/.htaccess）
# 禁止执行任何 PHP 文件
php_flag engine off
```

---

## 📊 项目评分

| 评分项 | 分数 | 权重 | 说明 |
|--------|------|------|------|
| 功能完整度 | 90/100 | 30% | 核心CRUD功能完善 |
| 安全评分 | 82/100 | 25% | CSRF/SQL注入已修复，待完善弱密码/安全头 |
| 代码质量 | 78/100 | 20% | MVC结构清晰，部分PHPDoc缺失 |
| 文档完整度 | 95/100 | 15% | 方案文档齐全 |
| 测试覆盖度 | 50/100 | 10% | 缺少自动化测试 |
| **综合评分** | **B+** | 100% | 具备生产使用条件 |

---

## 📝 项目方案文档

| 文档 | 说明 |
|------|------|
| `backups/WWW项目完整审查文档.md` | 完整项目审查，含架构、数据库、安全评估、部署指南 |
| `backups/网页导入内容智能分配方案.md` | 网络导入功能方案，智能解析+多表分配 |
| `backups/后台首页仪表盘实现方案.md` | 仪表盘改造方案，含6大区域设计 |
| `backups/数据导入导出实现方案.md` | 数据导入导出功能方案（含CSV/Excel/SQL格式） |

---

## 🐛 已知问题

| 问题 | 优先级 | 修复方式 |
|------|--------|----------|
| 表名 `S_subjbect` 拼写错误 | P0 | 执行 `scripts/migrate_fix_typo.sql` |
| 密码明文存储 | P0 | 改用 `password_hash()` |
| 上传目录无PHP执行防护 | P0 | 添加 `.htaccess` |
| 缺少 HTTP 安全头 | P1 | 入口文件添加 response header |
| 操作日志不完整 | P1 | 写操作前添加 LogModel::log() |
| 登录失败无锁定 | P2 | 添加失败计数+锁定逻辑 |

---

## 🔄 开发指南

### 添加新控制器

1. 在 `app/admin/controller/` 创建 `NewController.php`
2. 继承 `BaseController` 或 `Controller`
3. 在 `core/App.php` 注册路由（或使用默认路由）

```php
// app/admin/controller/NewController.php
<?php
namespace admin\controller;

class NewController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('New');
        $this->display('new.php');
    }

    public function add()
    {
        $this->checkCsrf();  // POST 请求验证
        // 业务逻辑...
    }
}
```

### 添加新模型

```php
// app/admin/model/NewModel.php
<?php
namespace admin\model;

use core\Model;

class NewModel extends Model
{
    protected $table = 'your_table';

    // 使用预处理SQL
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->prepare($sql, [$id]);
    }
}
```

### 添加新数据库表

1. 编辑 `core/Model.php` 添加表名常量
2. 创建对应的 Model
3. 更新 `backups/tables.sql`

---

## 📌 变更日志

### v2.0 (2026-06-25)

- ✅ 安全修复：CSRF Token、SQL注入预处理、XSS过滤
- ✅ Session固定防护
- ✅ 表名拼写修正迁移脚本
- ✅ 性能优化：索引、查询优化
- 📋 仪表盘改造方案已完成
- 📋 数据导入导出方案已完成
- 📋 网络导入智能分配方案已完成

### v1.0 (早期版本)

- 基础 MVC 架构搭建
- 22个后台控制器
- 9张核心数据表
- Smarty 模板引擎集成

---

## 📧 联系方式

- 维护者：Sky
- 时区：Asia/Shanghai

---

## 📄 许可证

本项目仅供学习参考使用。

---

**最后更新：** 2026-06-30
