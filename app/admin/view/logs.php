<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>操作日志 - 后台管理系统</title>
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
        .log-success { color: #67c23a; font-weight: bold; }
        .log-failed { color: #f56c6c; font-weight: bold; }
        .filter-form { margin-bottom: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #e6e6e6; border-radius: 4px; }
        .filter-form select, .filter-form input { padding: 6px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; margin-right: 8px; }
        .filter-form .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .btn-primary { background: #409eff; color: #fff; }
        .btn-primary:hover { background: #337ecc; }
        .btn-default { background: #f2f2f2; color: #666; text-decoration: none; display: inline-block; }
        .btn-default:hover { background: #e6e6e6; }
        .btn-danger { background: #f56c6c; color: #fff; }
        .btn-danger:hover { background: #e05050; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .badge { display: inline-block; padding: 2px 6px; background: #909399; color: #fff; border-radius: 3px; font-size: 11px; }
        .pagination { margin-top: 15px; text-align: center; }
        .pagination a, .pagination span { display: inline-block; padding: 5px 10px; margin: 0 2px; border: 1px solid #dcdfe6; border-radius: 3px; text-decoration: none; color: #666; font-size: 13px; }
        .pagination a:hover { background: #409eff; color: #fff; border-color: #409eff; }
        .pagination .active { background: #409eff; color: #fff; border-color: #409eff; }
        .text-center { text-align: center; }
        .text-muted { color: #999; }
        .pull-right { float: right; }
        .toolbar { margin-bottom: 15px; overflow: hidden; }
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
                    <h2>操作日志</h2>
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

                <div class="toolbar">
                    <a href="index.php?p=admin&c=Log&a=export&module={$filters.module}&date_from={$filters.date_from}&date_to={$filters.date_to}" class="btn btn-default btn-sm" style="float:right; margin-left:8px;">导出CSV</a>
                    <form action="/" method="post" style="display:inline; float:right;" onsubmit="return confirm('确定要清理日志吗？建议先导出备份。')">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Log">
                        <input type="hidden" name="a" value="clean">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
                        <input type="hidden" name="keep_days" value="90">
                        <button type="submit" class="btn btn-danger btn-sm">清理90天前日志</button>
                    </form>
                </div>

                <form method="get" class="filter-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Log">
                    <input type="hidden" name="a" value="index">
                    <select name="module">
                        <option value="">全部模块</option>
                        {foreach $modules as $mod}
                            <option value="{$mod}" {if $filters.module eq $mod}selected{/if}>{$mod}</option>
                        {/foreach}
                    </select>
                    <input type="text" name="username" placeholder="用户名" value="{$filters.username}">
                    <input type="date" name="date_from" value="{$filters.date_from}" placeholder="开始日期">
                    <input type="date" name="date_to" value="{$filters.date_to}" placeholder="结束日期">
                    <button type="submit" class="btn btn-primary btn-sm">筛选</button>
                    <a href="index.php?p=admin&c=Log&a=index" class="btn btn-default btn-sm">重置</a>
                </form>

                <table class="user-table">
                    <tr>
                        <th>ID</th>
                        <th>用户</th>
                        <th>模块</th>
                        <th>操作</th>
                        <th>详情</th>
                        <th>IP</th>
                        <th>时间</th>
                        <th>状态</th>
                    </tr>
                    {if $logs|@count eq 0}
                        <tr><td colspan="8" class="text-center text-muted">暂无日志</td></tr>
                    {else}
                        {foreach $logs as $log}
                        <tr>
                            <td>{$log.id}</td>
                            <td>{if $log.username}{$log.username}{else}-{/if}</td>
                            <td>{if $log.module}<span class="badge">{$log.module}</span>{else}-{/if}</td>
                            <td>{$log.action}</td>
                            <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{$log.detail}">{if $log.detail}{$log.detail|truncate:40}{else}-{/if}</td>
                            <td>{if $log.ip_address}{$log.ip_address}{else}-{/if}</td>
                            <td style="font-size:12px;">{$log.created_at}</td>
                            <td>{if $log.status eq '1'}<span class="log-success">成功</span>{else}<span class="log-failed" title="{$log.error_msg}">失败</span>{/if}</td>
                        </tr>
                        {/foreach}
                    {/if}
                </table>

                {if $totalPages gt 1}
                    <div class="pagination">
                        {if $page gt 1}
                            <a href="index.php?p=admin&c=Log&a=index&page=1&module={$filters.module}&username={$filters.username}&date_from={$filters.date_from}&date_to={$filters.date_to}&status={$filters.status}">首页</a>
                            <a href="index.php?p=admin&c=Log&a=index&page={$prevPage}&module={$filters.module}&username={$filters.username}&date_from={$filters.date_from}&date_to={$filters.date_to}&status={$filters.status}">上一页</a>
                        {/if}
                        {for $i=max(1, $page-2) to min($totalPages, $page+2)}
                            {if $i eq $page}
                                <span class="active">{$i}</span>
                            {else}
                                <a href="index.php?p=admin&c=Log&a=index&page={$i}&module={$filters.module}&username={$filters.username}&date_from={$filters.date_from}&date_to={$filters.date_to}&status={$filters.status}">{$i}</a>
                            {/if}
                        {/for}
                        {if $page lt $totalPages}
                            <a href="index.php?p=admin&c=Log&a=index&page={$nextPage}&module={$filters.module}&username={$filters.username}&date_from={$filters.date_from}&date_to={$filters.date_to}&status={$filters.status}">下一页</a>
                            <a href="index.php?p=admin&c=Log&a=index&page={$totalPages}&module={$filters.module}&username={$filters.username}&date_from={$filters.date_from}&date_to={$filters.date_to}&status={$filters.status}">尾页</a>
                        {/if}
                    </div>
                    <div class="text-center text-muted" style="margin-top:8px; font-size:13px;">共 {$total} 条日志</div>
                {/if}
            </article>
        </div>
    </div>
</body>
</html>
