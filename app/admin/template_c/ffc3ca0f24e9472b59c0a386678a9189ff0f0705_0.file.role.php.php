<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:57:30
  from '/home/sky/www/app/admin/view/role.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced7a4dad74_36358791',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ffc3ca0f24e9472b59c0a386678a9189ff0f0705' => 
    array (
      0 => '/home/sky/www/app/admin/view/role.php',
      1 => 1782377775,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced7a4dad74_36358791 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
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
                <li><form action="/" method="post"><input type="hidden" name="p" value="admin"><input type="hidden" name="c" value="Index"><input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
"><a href="/" onclick="this.parentNode.submit(); return false;">首页</a></form></li>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MainTitledata']->value, 'item', false, NULL, 'loop', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index']++;
?>
                    <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index'] : null) < 4) {?>
                        <li><form action="/" method="post"><input type="hidden" name="p" value="admin"><input type="hidden" name="c" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['types'];?>
"><input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
"><a href="/" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['item']->value['course'];?>
</a></form></li>
                    <?php }?>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
        </div>
        <div class="nav_right">
            <li><a href="/">前台首页</a></li>
            <li><a href="#">管理员：<?php echo $_smarty_tpl->tpl_vars['session_username']->value;?>
</a></li>
            <li><a href="index.php?p=admin&c=Auth&a=logout">退出登录</a></li>
        </div>
    </header>
    <div class="connect">
        <aside>
            <ul>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MainTitledata']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <li class="<?php echo $_smarty_tpl->tpl_vars['item']->value['className'];?>
">
                    <a><i class="icon-left fa-solid <?php echo $_smarty_tpl->tpl_vars['item']->value['iconName'];?>
"></i> <?php echo $_smarty_tpl->tpl_vars['item']->value['course'];?>
 <i class="icon-right fa-solid fa-chevron-down"></i></a>
                    <?php if ($_smarty_tpl->tpl_vars['infoMainTitle']->value == $_smarty_tpl->tpl_vars['item']->value['course']) {?>
                    <dl class="subtitle" style="display: block;">
                    <?php } else { ?>
                    <dl class="subtitle">
                    <?php }?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MinTitledata']->value, 'subitem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['subitem']->value) {
?>
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['course'] == $_smarty_tpl->tpl_vars['subitem']->value['course']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['subitem']->value['types'] == $_smarty_tpl->tpl_vars['C']->value) {?>
                                    <dd style="background-color: #3574c5;">
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="admin">
                                            <input type="hidden" name="c" value="<?php echo $_smarty_tpl->tpl_vars['subitem']->value['types'];?>
">
                                            <input type="hidden" name="f" value="<?php echo $_smarty_tpl->tpl_vars['subitem']->value['page'];?>
">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                            <a href="/" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['subitem']->value['subject'];?>
</a>
                                        </form>
                                    </dd>
                                <?php } else { ?>
                                    <dd>
                                        <form action="/" method="post">
                                            <input type="hidden" name="p" value="admin">
                                            <input type="hidden" name="c" value="<?php echo $_smarty_tpl->tpl_vars['subitem']->value['types'];?>
">
                                            <input type="hidden" name="f" value="<?php echo $_smarty_tpl->tpl_vars['subitem']->value['page'];?>
">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                            <a href="/" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['subitem']->value['subject'];?>
</a>
                                        </form>
                                    </dd>
                                <?php }?>
                            <?php }?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </dl>
                </li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
        </aside>
        <article>
            <div class="text"><h2>角色管理</h2></div>

            <?php if ($_SESSION['success_msg'] != '') {?>
                <div class="msg-success"><?php echo $_SESSION['success_msg'];?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 3000);<?php echo '</script'; ?>
>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['_SESSION']) ? $_smarty_tpl->tpl_vars['_SESSION']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['success_msg'] = '';
$_smarty_tpl->_assignInScope('_SESSION', $_tmp_array);?>
            <?php }?>
            <?php if ($_SESSION['error_msg'] != '') {?>
                <div class="msg-error"><?php echo $_SESSION['error_msg'];?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 3000);<?php echo '</script'; ?>
>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['_SESSION']) ? $_smarty_tpl->tpl_vars['_SESSION']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['error_msg'] = '';
$_smarty_tpl->_assignInScope('_SESSION', $_tmp_array);?>
            <?php }?>

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
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roles']->value, 'role');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['role']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
</td>
                            <td><code><?php echo $_smarty_tpl->tpl_vars['role']->value['slug'];?>
</code></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['role']->value['is_system'] == '1') {?><span class="tag tag-system">系统</span><?php } else { ?><span class="tag tag-custom">自定义</span><?php }?></td>
                            <td>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="Role">
                                    <input type="hidden" name="a" value="edit">
                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <button type="submit" class="btn-edit">编辑</button>
                                </form>
                                <?php if ($_smarty_tpl->tpl_vars['role']->value['is_system'] == '0') {?>
                                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定要删除角色 <?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
 吗？');">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="Role">
                                    <input type="hidden" name="a" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <button type="submit" class="btn-del">删除</button>
                                </form>
                                <?php }?>
                            </td>
                        </tr>
                        <?php
}
} else {
?>
                        <tr><td colspan="5" style="text-align:center;color:#999;">暂无角色</td></tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </table>
                </div>
                <div class="role-form">
                    <?php if ($_smarty_tpl->tpl_vars['editMode']->value == true && $_smarty_tpl->tpl_vars['editRole']->value) {?>
                    <div class="role-form-card">
                        <h3>编辑角色：<?php echo $_smarty_tpl->tpl_vars['editRole']->value['name'];?>
</h3>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Role">
                            <input type="hidden" name="a" value="edit">
                            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['editRole']->value['id'];?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">

                            <div class="field">
                                <label>角色名称</label>
                                <input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['editRole']->value['name'];?>
" required>
                            </div>
                            <div class="field">
                                <label>描述</label>
                                <textarea name="description"><?php echo $_smarty_tpl->tpl_vars['editRole']->value['description'];?>
</textarea>
                            </div>
                            <div class="field">
                                <label>权限设置</label>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['permGroups']->value, 'perms', false, 'group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value => $_smarty_tpl->tpl_vars['perms']->value) {
?>
                                <div class="perm-group">
                                    <h4><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
</h4>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['perms']->value, 'perm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['perm']->value) {
?>
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="<?php echo $_smarty_tpl->tpl_vars['perm']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['perm']->value,$_smarty_tpl->tpl_vars['rolePerms']->value)) {?>checked<?php }?>>
                                        <?php echo $_smarty_tpl->tpl_vars['permLabels']->value[$_smarty_tpl->tpl_vars['perm']->value];?>

                                    </label>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </div>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="保存">
                                <a href="index.php?p=admin&c=Role" style="margin-left:10px;color:#409eff;">取消</a>
                            </div>
                        </form>
                    </div>
                    <?php } else { ?>
                    <div class="role-form-card">
                        <h3>新增角色</h3>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Role">
                            <input type="hidden" name="a" value="add">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">

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
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['permGroups']->value, 'perms', false, 'group');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value => $_smarty_tpl->tpl_vars['perms']->value) {
?>
                                <div class="perm-group">
                                    <h4><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
</h4>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['perms']->value, 'perm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['perm']->value) {
?>
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="<?php echo $_smarty_tpl->tpl_vars['perm']->value;?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['permLabels']->value[$_smarty_tpl->tpl_vars['perm']->value];?>

                                    </label>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </div>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="创建角色">
                            </div>
                        </form>
                    </div>
                    <?php }?>
                </div>
            </div>
        </article>
    </div>
</div>
</body>
</html>
<?php }
}
