<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .user-toolbar { margin-bottom: 20px; }
        .user-toolbar .input-sub { margin-right: 10px; }
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th, .user-table td { padding: 10px 12px; border: 1px solid #e6e6e6; text-align: left; font-size: 14px; }
        .user-table th { background: #f2f2f2; font-weight: bold; }
        .user-table tr:hover { background: #f5f7fa; }
        .user-form { max-width: 500px; }
        .user-form .field { margin-bottom: 15px; }
        .user-form label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
        .user-form input[type="text"], .user-form input[type="password"] { width: 100%; padding: 8px 10px; border: 1px solid #dcdfe6; border-radius: 4px; box-sizing: border-box; }
        .user-form select { width: 100%; padding: 8px 10px; border: 1px solid #dcdfe6; border-radius: 4px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .btn-del { color: #f56c6c; cursor: pointer; background: none; border: none; font-size: 14px; }
        .btn-del:hover { text-decoration: underline; }
        .btn-edit { color: #409eff; cursor: pointer; background: none; border: none; font-size: 14px; }
        .btn-edit:hover { text-decoration: underline; }
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
                    <h2>用户管理</h2>
                    <form action="/" method="post" style="display:inline;">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="User">
                        <input type="hidden" name="a" value="add">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
                        <input class="input-sub" type="submit" value="新增用户">
                    </form>
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

                {if isset($editMode) && $editMode}
                    <div class="text"><h3>{if $editUser.id}编辑用户{else}新增用户{/if}</h3></div>
                    <div class="user-form">
                        {if $error neq ''}
                            <div class="msg-error">{$error}</div>
                        {/if}
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="User">
                            <input type="hidden" name="a" value="{if $editUser.id}edit{else}add{/if}">
                            <input type="hidden" name="id" value="{$editUser.id}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">
                            <div class="field">
                                <label>用户名</label>
                                <input type="text" name="username" value="{$editUser.username}" required>
                            </div>
                            <div class="field">
                                <label>密码 {if $editUser.id}<span style="color:#999;font-size:12px;">(留空则不修改)</span>{/if}</label>
                                <input type="password" name="password" {if !$editUser.id}required{/if}>
                            </div>
                            <div class="field">
                                <label>权限</label>
                                <select name="is_admin">
                                    <option value="0" {if $editUser.is_admin eq '0'}selected{/if}>普通用户</option>
                                    <option value="1" {if $editUser.is_admin eq '1'}selected{/if}>管理员</option>
                                </select>
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="保存">
                                <a href="/index.php?p=admin&c=User&a=index" style="margin-left:10px;color:#409eff;">返回</a>
                            </div>
                        </form>
                    </div>
                {else}
                    <table class="user-table">
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>权限</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        {foreach $users as $item}
                        <tr>
                            <td>{$item.id}</td>
                            <td>{$item.username}</td>
                            <td>{if $item.is_admin eq '1'}管理员{else}普通用户{/if}</td>
                            <td>{$item.reg_time|date_format:"%Y-%m-%d %H:%M"}</td>
                            <td>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="a" value="edit">
                                    <input type="hidden" name="id" value="{$item.id}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <button type="submit" class="btn-edit">编辑</button>
                                </form>
                                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定要删除用户 {$item.username} 吗？');">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="a" value="delete">
                                    <input type="hidden" name="id" value="{$item.id}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <button type="submit" class="btn-del">删除</button>
                                </form>
                            </td>
                        </tr>
                        {/foreach}
                    </table>

                    {if $totalPages gt 1}
                        <div class="kg-pager">
                            <div class="layui-box layui-laypage">
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="1">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                                </form>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="{$prevPage}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                                </form>
                                <span>第 {$page}/{$totalPages} 页</span>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="{$nextPage}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                                </form>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="{$totalPages}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                                </form>
                            </div>
                        </div>
                    {/if}
                {/if}
            </article>
        </div>
    </div>
</body>
</html>
