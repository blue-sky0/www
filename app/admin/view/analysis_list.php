<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>访问日志 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .log-table { width: 100%; border-collapse: collapse; }
        .log-table th, .log-table td { padding: 6px 8px; border: 1px solid #e6e6e6; text-align: left; font-size: 12px; }
        .log-table th { background: #f2f2f2; font-weight: bold; white-space: nowrap; }
        .log-table tr:hover { background: #f5f7fa; }
        .filter-bar { margin-bottom: 15px; padding: 12px; background: #fafafa; border: 1px solid #e6e6e6; border-radius: 4px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .filter-bar select, .filter-bar input { padding: 5px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; }
        .filter-bar .input-sub { font-size: 13px; padding: 5px 12px; }
        .tag { display: inline-block; padding: 1px 4px; border-radius: 2px; font-size: 10px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-guest { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .break-all { word-break: break-all; }
        .btn-back { display: inline-block; padding: 6px 15px; background: #409eff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
        .btn-back:hover { background: #337ecc; }
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
                <h2>访问日志</h2>
                <a href="index.php?p=admin&c=BehaviorAnalysis" style="font-size:13px;color:#409eff;margin-left:10px;">返回分析 &raquo;</a>
            </div>

            <div class="filter-bar">
                <form action="/" method="get" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="BehaviorAnalysis">
                    <input type="hidden" name="a" value="list">
                    <select name="user_type">
                        <option value="">全部类型</option>
                        <option value="admin" {if $filters.user_type eq 'admin'}selected{/if}>管理员</option>
                        <option value="user" {if $filters.user_type eq 'user'}selected{/if}>用户</option>
                        <option value="guest" {if $filters.user_type eq 'guest'}selected{/if}>游客</option>
                    </select>
                    <input type="text" name="ip_address" placeholder="IP" value="{$filters.ip_address}" style="width:120px;">
                    <input type="text" name="url" placeholder="URL" value="{$filters.url}" style="width:180px;">
                    <input type="date" name="date_from" value="{$filters.date_from}" style="width:140px;">
                    <input type="date" name="date_to" value="{$filters.date_to}" style="width:140px;">
                    <input class="input-sub" type="submit" value="筛选">
                    <a href="index.php?p=admin&c=BehaviorAnalysis&a=list" style="font-size:13px;color:#999;">重置</a>
                </form>
            </div>

            <table class="log-table">
                <tr>
                    <th>时间</th>
                    <th>类型</th>
                    <th>Session</th>
                    <th>IP</th>
                    <th>方法</th>
                    <th style="min-width:200px;">URL</th>
                    <th>来源</th>
                    <th>耗时</th>
                    <th>操作</th>
                </tr>
                {foreach $logs as $l}
                <tr>
                    <td nowrap><small>{$l.created_at}</small></td>
                    <td>
                        {if $l.user_type eq 'admin'}<span class="tag tag-admin">管理员</span>
                        {elseif $l.user_type eq 'user'}<span class="tag tag-user">用户</span>
                        {else}<span class="tag tag-guest">游客</span>
                        {/if}
                    </td>
                    <td style="font-family:monospace;font-size:10px;">{$l.session_id|substr:0:12}</td>
                    <td><small>{$l.ip_address}</small></td>
                    <td><small>{$l.request_method}</small></td>
                    <td class="break-all" style="font-size:11px;max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{$l.request_url}">{$l.request_url}</td>
                    <td class="break-all" style="font-size:11px;max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{$l.referer_url|default:''}">{$l.referer_url|default:'-'}</td>
                    <td><small>{if $l.response_time}{$l.response_time}ms{else}-{/if}</small></td>
                    <td>
                        <a href="index.php?p=admin&c=BehaviorAnalysis&a=journey&session_id={$l.session_id|urlencode}" style="font-size:11px;color:#409eff;">路径</a>
                    </td>
                </tr>
                {foreachelse}
                <tr><td colspan="9" style="text-align:center;color:#999;padding:30px;">暂无访问记录</td></tr>
                {/foreach}
            </table>

            {if $totalPages gt 1}
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="BehaviorAnalysis">
                            <input type="hidden" name="a" value="list">
                            <input type="hidden" name="page" value="1">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="BehaviorAnalysis">
                            <input type="hidden" name="a" value="list">
                            <input type="hidden" name="page" value="{$prevPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 {$page}/{$totalPages} 页</span>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="BehaviorAnalysis">
                            <input type="hidden" name="a" value="list">
                            <input type="hidden" name="page" value="{$nextPage}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="BehaviorAnalysis">
                            <input type="hidden" name="a" value="list">
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
