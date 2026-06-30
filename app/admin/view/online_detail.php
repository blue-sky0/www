<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会话详情 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <style>
        .detail-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 25px; margin-bottom: 20px; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th, .detail-table td { padding: 10px 15px; border: 1px solid #e6e6e6; text-align: left; font-size: 14px; }
        .detail-table th { background: #f2f2f2; font-weight: bold; width: 140px; }
        .tag { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .break-word { word-break: break-all; }
        .btn-back { display: inline-block; padding: 6px 15px; background: #409eff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
        .btn-back:hover { background: #337ecc; }
    </style>
</head>
<body>
<div id="container">
    <div style="padding:20px;">
        <a href="index.php?p=admin&c=OnlineUser" class="btn-back">&laquo; 返回在线用户</a>
        <h2>会话详情</h2>
        <div class="detail-box">
            <table class="detail-table">
                <tr><th>Session ID</th><td class="break-word" style="font-family:monospace;">{$session.session_id}</td></tr>
                <tr><th>用户类型</th><td>{if $session.user_type eq 'admin'}<span class="tag tag-admin">管理员</span>{elseif $session.user_type eq 'user'}<span class="tag tag-user">用户</span>{else}<span class="tag">游客</span>{/if}</td></tr>
                <tr><th>用户名</th><td>{$session.username|default:'<em style="color:#999;">游客</em>'}</td></tr>
                <tr><th>用户ID</th><td>{$session.user_id|default:'-'}</td></tr>
                <tr><th>IP地址</th><td>{$session.ip_address}</td></tr>
                <tr><th>最后活动</th><td>{$session.last_activity}</td></tr>
                <tr><th>登录时间</th><td>{$session.login_time|default:'-'}</td></tr>
                <tr><th>当前页面</th><td class="break-word" style="font-size:12px;">{$session.current_url|default:'-'}</td></tr>
                <tr><th>User Agent</th><td class="break-word" style="font-size:12px;color:#999;">{$session.user_agent|default:'-'}</td></tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
