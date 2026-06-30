<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录历史 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th, .user-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .user-table th { background: #f2f2f2; font-weight: bold; }
        .user-table tr:hover { background: #f5f7fa; }
        .filter-bar { margin-bottom: 15px; padding: 12px; background: #fafafa; border: 1px solid #e6e6e6; border-radius: 4px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .filter-bar select, .filter-bar input { padding: 5px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; }
        .filter-bar .input-sub { font-size: 13px; padding: 5px 12px; }
        .tag { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-success { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-failed { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-kicked { background: #fdf6ec; color: #e6a23c; border: 1px solid #faecd8; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
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
                <h2>登录历史</h2>
                <a href="index.php?p=admin&c=OnlineUser" style="font-size:13px;color:#409eff;margin-left:10px;">返回在线用户 &raquo;</a>
            </div>

            <div class="filter-bar">
                <form action="/" method="get" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="OnlineUser">
                    <input type="hidden" name="a" value="history">
                    <select name="user_type">
                        <option value="">全部类型</option>
                        <option value="admin" {if $filters.user_type eq 'admin'}selected{/if}>管理员</option>
                        <option value="user" {if $filters.user_type eq 'user'}selected{/if}>用户</option>
                    </select>
                    <select name="status">
                        <option value="">全部状态</option>
                        <option value="success" {if $filters.status eq 'success'}selected{/if}>成功</option>
                        <option value="failed" {if $filters.status eq 'failed'}selected{/if}>失败</option>
                        <option value="kicked" {if $filters.status eq 'kicked'}selected{/if}>踢出</option>
                    </select>
                    <input type="text" name="username" placeholder="用户名" value="{$filters.username}" style="width:120px;">
                    <input type="text" name="ip_address" placeholder="IP地址" value="{$filters.ip_address}" style="width:130px;">
                    <input type="date" name="date_from" value="{$filters.date_from}" style="width:140px;">
                    <input type="date" name="date_to" value="{$filters.date_to}" style="width:140px;">
                    <input class="input-sub" type="submit" value="筛选">
                    <a href="index.php?p=admin&c=OnlineUser&a=history" style="font-size:13px;color:#999;">重置</a>
                </form>
            </div>

            <table class="user-table">
                <tr>
                    <th>用户名</th>
                    <th>类型</th>
                    <th>IP地址</th>
                    <th>登录时间</th>
                    <th>退出时间</th>
                    <th>状态</th>
                </tr>
                {foreach $history as $h}
                <tr>
                    <td>{$h.username|default:'<em style="color:#999;">未知</em>'}</td>
                    <td>{if $h.user_type eq 'admin'}<span class="tag tag-admin">管理员</span>{else}<span class="tag tag-user">用户</span>{/if}</td>
                    <td><small>{$h.ip_address}</small></td>
                    <td><small>{$h.login_time}</small></td>
                    <td><small>{$h.logout_time|default:'-'}</small></td>
                    <td>
                        {if $h.status eq 'success'}<span class="tag tag-success">成功</span>
                        {elseif $h.status eq 'failed'}<span class="tag tag-failed">失败</span>
                        {elseif $h.status eq 'kicked'}<span class="tag tag-kicked">踢出</span>
                        {else}{$h.status}{/if}
                    </td>
                </tr>
                {foreachelse}
                <tr><td colspan="6" style="text-align:center;color:#999;padding:30px;">暂无记录</td></tr>
                {/foreach}
            </table>

            {if $totalPages gt 1}
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="history">
                            <input type="hidden" name="page" value="1">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="history">
                            <input type="hidden" name="page" value="{$prevPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 {$page}/{$totalPages} 页</span>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="history">
                            <input type="hidden" name="page" value="{$nextPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="history">
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
