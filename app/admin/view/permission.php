<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>权限分配 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th, .user-table td { padding: 10px 12px; border: 1px solid #e6e6e6; text-align: left; font-size: 14px; }
        .user-table th { background: #f2f2f2; font-weight: bold; }
        .user-table tr:hover { background: #f5f7fa; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .role-checkbox-group { max-height: 120px; overflow-y: auto; border: 1px solid #dcdfe6; border-radius: 4px; padding: 8px; }
        .role-checkbox-group label { display: block; margin: 4px 0; font-size: 13px; cursor: pointer; }
        .role-checkbox-group label input { margin-right: 5px; }
        .input-sub { background: #409eff; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .input-sub:hover { background: #337ecc; }
        .input-sub-sm { padding: 4px 12px; font-size: 12px; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 12px; margin: 2px; }
        .tag-role { background: #ecf5ff; color: #409eff; border: 1px solid #d9ecff; }
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
            <div class="text"><h2>权限分配</h2></div>

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

            <table class="user-table">
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>当前角色</th>
                    <th>分配角色</th>
                </tr>
                {foreach $users as $user}
                {if $user.is_admin eq '1'}
                <tr>
                    <td>{$user.id}</td>
                    <td>{$user.username}</td>
                    <td>
                        {if isset($userRoles[$user.id])}
                            {foreach $userRoles[$user.id] as $ur}
                            <span class="tag tag-role">{$ur.name}</span>
                            {/foreach}
                        {else}
                            <span style="color:#999;">未分配</span>
                        {/if}
                    </td>
                    <td>
                        <form action="/" method="post" style="display:flex; align-items:center; gap:8px;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="a" value="assignRole">
                            <input type="hidden" name="admin_id" value="{$user.id}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <div class="role-checkbox-group">
                                {foreach $roles as $role}
                                <label>
                                    <input type="checkbox" name="role_ids[]" value="{$role.id}"
                                        {if isset($userRoles[$user.id])}
                                            {foreach $userRoles[$user.id] as $ur}
                                                {if $ur.id eq $role.id}checked{/if}
                                            {/foreach}
                                        {/if}>
                                    {$role.name}
                                </label>
                                {/foreach}
                            </div>
                            <input class="input-sub input-sub-sm" type="submit" value="保存">
                        </form>
                    </td>
                </tr>
                {/if}
                {foreachelse}
                <tr><td colspan="4" style="text-align:center;color:#999;padding:40px;">暂无管理员用户</td></tr>
                {/foreach}
            </table>

            {if $totalPages gt 1}
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="{$prevPage}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 {$page}/{$totalPages} 页</span>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="{$nextPage}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="{$totalPages}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                        </form>
                    </div>
                </div>
            {/if}
        </article>
    </div>
</div>
</body>
</html>
