<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>角色管理 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .content { padding: 20px; }
        .content h2 { margin-bottom: 20px; color: #333; }
        .role-layout { display: flex; gap: 20px; }
        .role-list { flex: 1; min-width: 0; }
        .role-form { flex: 1; min-width: 0; }
        @media (max-width: 900px) { .role-layout { flex-direction: column; } }
        .role-table { width: 100%; border-collapse: collapse; }
        .role-table th, .role-table td { padding: 10px 12px; border: 1px solid #e6e6e6; text-align: left; font-size: 14px; }
        .role-table th { background: #f2f2f2; font-weight: bold; }
        .role-table tr:hover { background: #f5f7fa; }
        .role-form-card { background: #fff; border: 1px solid #dcdfe6; border-radius: 6px; padding: 20px; }
        .role-form-card h3 { margin-top: 0; margin-bottom: 20px; color: #333; border-bottom: 1px solid #e6e6e6; padding-bottom: 10px; }
        .field { margin-bottom: 15px; }
        .field label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; font-weight: bold; }
        .field input[type="text"], .field textarea { width: 100%; padding: 8px 10px; border: 1px solid #dcdfe6; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        .field textarea { min-height: 60px; resize: vertical; }
        .field .form-text { font-size: 12px; color: #999; margin-top: 4px; }
        .perm-group { margin-bottom: 15px; }
        .perm-group h4 { margin: 0 0 8px 0; color: #555; font-size: 14px; border-left: 3px solid #409eff; padding-left: 10px; }
        .perm-group label { display: inline-block; margin-right: 15px; margin-bottom: 6px; font-size: 13px; color: #555; cursor: pointer; }
        .perm-group label input { margin-right: 3px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .input-sub { background: #409eff; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .input-sub:hover { background: #337ecc; }
        .btn-del { color: #f56c6c; cursor: pointer; background: none; border: none; font-size: 14px; }
        .btn-del:hover { text-decoration: underline; }
        .btn-edit { color: #409eff; cursor: pointer; background: none; border: none; font-size: 14px; }
        .btn-edit:hover { text-decoration: underline; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 12px; }
        .tag-system { background: #f0f9eb; color: #67c23a; }
        .tag-custom { background: #ecf5ff; color: #409eff; }
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
            <div class="text"><h2>角色管理</h2></div>

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

            <div class="role-layout">
                <div class="role-list">
                    <table class="role-table">
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>标识</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        {foreach $roles as $role}
                        <tr>
                            <td>{$role.id}</td>
                            <td>{$role.name}</td>
                            <td><code>{$role.slug}</code></td>
                            <td>{if $role.is_system eq '1'}<span class="tag tag-system">系统</span>{else}<span class="tag tag-custom">自定义</span>{/if}</td>
                            <td>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="Role">
                                    <input type="hidden" name="a" value="edit">
                                    <input type="hidden" name="id" value="{$role.id}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <button type="submit" class="btn-edit">编辑</button>
                                </form>
                                {if $role.is_system eq '0'}
                                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定要删除角色 {$role.name} 吗？');">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="Role">
                                    <input type="hidden" name="a" value="delete">
                                    <input type="hidden" name="id" value="{$role.id}">
                                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                                    <button type="submit" class="btn-del">删除</button>
                                </form>
                                {/if}
                            </td>
                        </tr>
                        {foreachelse}
                        <tr><td colspan="5" style="text-align:center;color:#999;">暂无角色</td></tr>
                        {/foreach}
                    </table>
                </div>
                <div class="role-form">
                    {if $editMode eq true && $editRole}
                    <div class="role-form-card">
                        <h3>编辑角色：{$editRole.name}</h3>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Role">
                            <input type="hidden" name="a" value="edit">
                            <input type="hidden" name="id" value="{$editRole.id}">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">

                            <div class="field">
                                <label>角色名称</label>
                                <input type="text" name="name" value="{$editRole.name}" required>
                            </div>
                            <div class="field">
                                <label>描述</label>
                                <textarea name="description">{$editRole.description}</textarea>
                            </div>
                            <div class="field">
                                <label>权限设置</label>
                                {foreach $permGroups as $group => $perms}
                                <div class="perm-group">
                                    <h4>{$group}</h4>
                                    {foreach $perms as $perm}
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{$perm}" {if in_array($perm, $rolePerms)}checked{/if}>
                                        {$permLabels[$perm]}
                                    </label>
                                    {/foreach}
                                </div>
                                {/foreach}
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="保存">
                                <a href="index.php?p=admin&c=Role" style="margin-left:10px;color:#409eff;">取消</a>
                            </div>
                        </form>
                    </div>
                    {else}
                    <div class="role-form-card">
                        <h3>新增角色</h3>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Role">
                            <input type="hidden" name="a" value="add">
                            <input type="hidden" name="csrf_token" value="{$csrf_token}">

                            <div class="field">
                                <label>角色名称</label>
                                <input type="text" name="name" required placeholder="如：内容编辑">
                            </div>
                            <div class="field">
                                <label>角色标识</label>
                                <input type="text" name="slug" required placeholder="如：editor（英文字母和下划线）">
                                <div class="form-text">唯一标识，创建后不可修改</div>
                            </div>
                            <div class="field">
                                <label>描述</label>
                                <textarea name="description" placeholder="角色描述（可选）"></textarea>
                            </div>
                            <div class="field">
                                <label>权限设置</label>
                                {foreach $permGroups as $group => $perms}
                                <div class="perm-group">
                                    <h4>{$group}</h4>
                                    {foreach $perms as $perm}
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{$perm}">
                                        {$permLabels[$perm]}
                                    </label>
                                    {/foreach}
                                </div>
                                {/foreach}
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="创建角色">
                            </div>
                        </form>
                    </div>
                    {/if}
                </div>
            </div>
        </article>
    </div>
</div>
</body>
</html>
