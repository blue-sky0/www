<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线用户管理 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 26px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .stat-red .stat-value { color: #f56c6c; } .stat-blue .stat-value { color: #409eff; }
        .stat-green .stat-value { color: #67c23a; } .stat-orange .stat-value { color: #e6a23c; }
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th, .user-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .user-table th { background: #f2f2f2; font-weight: bold; }
        .user-table tr:hover { background: #f5f7fa; }
        .filter-bar { margin-bottom: 15px; padding: 12px; background: #fafafa; border: 1px solid #e6e6e6; border-radius: 4px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .filter-bar select, .filter-bar input { padding: 5px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; }
        .filter-bar .input-sub { font-size: 13px; padding: 5px 12px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .tag { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-guest { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .btn-kick { color: #f56c6c; cursor: pointer; background: none; border: 1px solid #f56c6c; border-radius: 3px; font-size: 12px; padding: 2px 8px; }
        .btn-kick:hover { background: #fef0f0; }
        .btn-detail { color: #409eff; cursor: pointer; background: none; border: 1px solid #409eff; border-radius: 3px; font-size: 12px; padding: 2px 8px; text-decoration: none; }
        .btn-detail:hover { background: #ecf5ff; }
    </style>
</head>
<body>
<div id="container">
    <header>
        <div class="nav_left"><ul><li>后台管理系统</li></ul></div>
        <div class="nav_middle">
            <ul>
                <li><form action="/" method="post"><input type="hidden" name="p" value="admin"><input type="hidden" name="c" value="Index"><input type="hidden" name="csrf_token" value="{$csrf_token}"><a href="/" onclick="this.parentNode.submit(); return false;">首页</a></form></li>
                {foreach from=$MainTitledata item=item name=loop}
                    {if $smarty.foreach.loop.index < 4}
                        <li><form action="/" method="post"><input type="hidden" name="p" value="admin"><input type="hidden" name="c" value="{$item.types}"><input type="hidden" name="csrf_token" value="{$csrf_token}"><a href="/" onclick="this.parentNode.submit(); return false;">{$item.course}</a></form></li>
                    {/if}
                {/foreach}
            </ul>
        </div>
        <div class="nav_right">
            <li><a href="/">前台首页</a></li>
            <li><a href="#">管理员：{$session_username}</a></li>
            <li><a href="index.php?p=admin&c=Auth&a=logout">退出登录</a></li>
        </div>
    </header>
    <div class="connect">
        <aside>
            <ul>
                {foreach $MainTitledata as $item}
                <li class="{$item.className}">
                    <a><i class="icon-left fa-solid {$item.iconName}"></i> {$item.course} <i class="icon-right fa-solid fa-chevron-down"></i></a>
                    {if $infoMainTitle eq $item.course}
                    <dl class="subtitle" style="display: block;">
                    {else}
                    <dl class="subtitle">
                    {/if}
                        {foreach $MinTitledata as $subitem}
                            {if $item.course eq $subitem.course}
                                {if $subitem.types eq $C}
                                    <dd style="background-color: #3574c5;">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="admin">
                                            <input type="hidden" name="c" value="{$subitem.types}">
                                            <input type="hidden" name="f" value="{$subitem.page}">
                                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                            <a href="/" onclick="this.parentNode.submit(); return false;">{$subitem.subject}</a>
                                        </form>
                                    </dd>
                                {else}
                                    <dd>
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="admin">
                                            <input type="hidden" name="c" value="{$subitem.types}">
                                            <input type="hidden" name="f" value="{$subitem.page}">
                                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                            <a href="/" onclick="this.parentNode.submit(); return false;">{$subitem.subject}</a>
                                        </form>
                                    </dd>
                                {/if}
                            {/if}
                        {/foreach}
                    </dl>
                </li>
                {/foreach}
            </ul>
        </aside>
        <article>
            <div class="text">
                <h2>在线用户管理</h2>
                <a href="index.php?p=admin&c=OnlineUser&a=history" style="font-size:13px;color:#409eff;margin-left:10px;">登录历史 &raquo;</a>
            </div>

            {if $smarty.session.success_msg neq ''}
                <div class="msg-success">{$smarty.session.success_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 3000);</script>
                {$_SESSION['success_msg'] = ''}
            {/if}
            {if $smarty.session.error_msg neq ''}
                <div class="msg-error">{$smarty.session.error_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 3000);</script>
                {$_SESSION['error_msg'] = ''}
            {/if}

            <div class="stats-grid">
                <div class="stat-card stat-blue"><div class="stat-value">{$overview.total_online}</div><div class="stat-label">总在线</div></div>
                <div class="stat-card stat-red"><div class="stat-value">{$overview.admin_online}</div><div class="stat-label">管理员</div></div>
                <div class="stat-card stat-green"><div class="stat-value">{$overview.user_online}</div><div class="stat-label">注册用户</div></div>
                <div class="stat-card stat-orange"><div class="stat-value">{$overview.guest_online}</div><div class="stat-label">游客</div></div>
                <div class="stat-card stat-blue"><div class="stat-value">{$overview.unique_ips}</div><div class="stat-label">独立IP</div></div>
            </div>

            <div class="filter-bar">
                <form action="/" method="get" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="OnlineUser">
                    <input type="hidden" name="a" value="index">
                    <select name="user_type">
                        <option value="">全部类型</option>
                        <option value="admin" {if $filters.user_type eq 'admin'}selected{/if}>管理员</option>
                        <option value="user" {if $filters.user_type eq 'user'}selected{/if}>用户</option>
                    </select>
                    <input type="text" name="username" placeholder="用户名" value="{$filters.username}" style="width:120px;">
                    <input type="text" name="ip_address" placeholder="IP地址" value="{$filters.ip_address}" style="width:130px;">
                    <input class="input-sub" type="submit" value="筛选" style="font-size:13px;padding:5px 12px;">
                    <a href="index.php?p=admin&c=OnlineUser" style="font-size:13px;color:#999;">重置</a>
                </form>
            </div>

            <table class="user-table">
                <tr>
                    <th>Session ID</th>
                    <th>类型</th>
                    <th>用户名</th>
                    <th>IP地址</th>
                    <th>最后活动</th>
                    <th>登录时间</th>
                    <th>操作</th>
                </tr>
                {foreach $onlineUsers as $u}
                <tr>
                    <td style="font-family:monospace;font-size:11px;">{$u.session_id|substr:0:16}...</td>
                    <td>{if $u.user_type eq 'admin'}<span class="tag tag-admin">管理员</span>{elseif $u.user_type eq 'user'}<span class="tag tag-user">用户</span>{else}<span class="tag tag-guest">游客</span>{/if}</td>
                    <td>{$u.username|default:'<em style="color:#999;">游客</em>'}</td>
                    <td><small>{$u.ip_address}</small></td>
                    <td><small>{$u.last_activity}</small></td>
                    <td><small>{$u.login_time|default:'-'}</small></td>
                    <td>
                        <a href="index.php?p=admin&c=OnlineUser&a=detail&session_id={$u.session_id|urlencode}" class="btn-detail">详情</a>
                        <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定踢出该用户？')">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="kick">
                            <input type="hidden" name="session_id" value="{$u.session_id}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <button type="submit" class="btn-kick">踢出</button>
                        </form>
                    </td>
                </tr>
                {foreachelse}
                <tr><td colspan="7" style="text-align:center;color:#999;padding:30px;">暂无在线用户</td></tr>
                {/foreach}
            </table>

            {if $totalPages gt 1}
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="1">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="{$prevPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 {$page}/{$totalPages} 页</span>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="{$nextPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="{$totalPages}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                        </form>
                    </div>
                </div>
            {/if}
            <div style="text-align:center;color:#999;font-size:12px;margin-top:10px;">共 {$total} 条记录</div>
        </article>
    </div>
</div>
</body>
</html>
