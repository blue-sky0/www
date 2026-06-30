<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>缓存管理 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 26px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .stat-blue .stat-value { color: #409eff; } .stat-green .stat-value { color: #67c23a; }
        .stat-orange .stat-value { color: #e6a23c; } .stat-red .stat-value { color: #f56c6c; }
        .cache-table { width: 100%; border-collapse: collapse; }
        .cache-table th, .cache-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .cache-table th { background: #f2f2f2; font-weight: bold; }
        .cache-table tr:hover { background: #f5f7fa; }
        .action-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-bottom: 20px; }
        .action-card h3 { margin: 0 0 10px 0; font-size: 15px; }
        .action-bar { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 6px 15px; border-radius: 4px; font-size: 13px; text-decoration: none; cursor: pointer; border: none; }
        .btn-primary { background: #409eff; color: #fff; } .btn-primary:hover { background: #337ecc; }
        .btn-danger { background: #f56c6c; color: #fff; } .btn-danger:hover { background: #d9534f; }
        .btn-warning { background: #e6a23c; color: #fff; } .btn-warning:hover { background: #cf9236; }
        .btn-success { background: #67c23a; color: #fff; } .btn-success:hover { background: #5daf34; }
        .btn-sm { padding: 3px 8px; font-size: 12px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .badge-warning { background: #fdf6ec; color: #e6a23c; border: 1px solid #faecd8; }
        .badge-success { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .badge-info { background: #ecf5ff; color: #409eff; border: 1px solid #d9ecff; }
        .recommend-box { padding: 12px; background: #fafafa; border: 1px solid #e6e6e6; border-radius: 4px; margin-bottom: 15px; }
        .recommend-box ul { margin: 0; padding-left: 20px; }
        .recommend-box li { font-size: 13px; color: #666; margin-bottom: 4px; }
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
            <div class="text"><h2>缓存管理</h2></div>

            {if $smarty.session.success_msg neq ''}
                <div class="msg-success">{$smarty.session.success_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 4000);</script>
                {$_SESSION['success_msg'] = ''}
            {/if}
            {if $smarty.session.error_msg neq ''}
                <div class="msg-error">{$smarty.session.error_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 4000);</script>
                {$_SESSION['error_msg'] = ''}
            {/if}

            <div class="stats-grid">
                <div class="stat-card stat-blue"><div class="stat-value">{$stats.total_files}</div><div class="stat-label">缓存文件数</div></div>
                <div class="stat-card stat-green"><div class="stat-value">{$stats.size_fmt}</div><div class="stat-label">总大小</div></div>
                <div class="stat-card stat-orange"><div class="stat-value">{$stats.total_expired}</div><div class="stat-label">过期文件</div></div>
                <div class="stat-card stat-red"><div class="stat-value">{$stats.smarty_files}</div><div class="stat-label">Smarty 编译文件</div></div>
            </div>

            {if $recommendations|@count gt 0}
            <div class="recommend-box">
                <strong style="font-size:13px;">优化建议：</strong>
                <ul>
                {foreach $recommendations as $r}
                    <li>{$r}</li>
                {/foreach}
                </ul>
            </div>
            {/if}

            <div class="action-card">
                <h3>缓存操作</h3>
                <div class="action-bar">
                    <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定清理所有缓存？')">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Cache">
                        <input type="hidden" name="a" value="clear">
                        <input type="hidden" name="type" value="all">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
                        <button type="submit" class="btn btn-danger">清理全部缓存</button>
                    </form>
                    <form action="/" method="post" style="display:inline;">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Cache">
                        <input type="hidden" name="a" value="clear">
                        <input type="hidden" name="type" value="expired">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
                        <button type="submit" class="btn btn-warning">清理过期缓存</button>
                    </form>
                    {foreach $stats.types as $key => $t}
                    <form action="/" method="post" style="display:inline;">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Cache">
                        <input type="hidden" name="a" value="clear">
                        <input type="hidden" name="type" value="{$key}">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
                        <button type="submit" class="btn btn-primary btn-sm">清理 {$t.label}</button>
                    </form>
                    {/foreach}
                </div>
            </div>

            <div class="action-card">
                <h3>缓存详情</h3>
                <table class="cache-table">
                    <tr>
                        <th>类型</th>
                        <th>文件数</th>
                        <th>总大小</th>
                        <th>过期</th>
                        <th>最长保留</th>
                        <th>最新文件</th>
                        <th>操作</th>
                    </tr>
                    {foreach $stats.types as $key => $t}
                    <tr>
                        <td><strong>{$t.label}</strong></td>
                        <td>{$t.file_count}</td>
                        <td>{$t.size_fmt}</td>
                        <td>{if $t.expired_count gt 0}<span class="badge badge-warning">{$t.expired_count}</span>{else}<span class="badge badge-success">0</span>{/if}</td>
                        <td><small>{$t.max_age}s</small></td>
                        <td><small>{$t.newest}</small></td>
                        <td>
                            <form action="/" method="post" style="display:inline;">
                                <input type="hidden" name="p" value="admin">
                                <input type="hidden" name="c" value="Cache">
                                <input type="hidden" name="a" value="clear">
                                <input type="hidden" name="type" value="{$key}">
                                <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                <button type="submit" class="btn btn-primary btn-sm">清理</button>
                            </form>
                        </td>
                    </tr>
                    {foreachelse}
                    <tr><td colspan="7" style="text-align:center;color:#999;padding:30px;">暂无缓存数据</td></tr>
                    {/foreach}
                </table>
            </div>
        </article>
    </div>
</div>
</body>
</html>
