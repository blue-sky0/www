<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:57:31
  from '/home/sky/www/app/admin/view/permission.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced7b59e257_78608227',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44c67da78764dcba7e95d71a41ffed487ee07047' => 
    array (
      0 => '/home/sky/www/app/admin/view/permission.php',
      1 => 1782377774,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced7b59e257_78608227 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
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
            <div class="text"><h2>权限分配</h2></div>

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

            <table class="user-table">
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>当前角色</th>
                    <th>分配角色</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'user');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
?>
                <?php if ($_smarty_tpl->tpl_vars['user']->value['is_admin'] == '1') {?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</td>
                    <td>
                        <?php if (isset($_smarty_tpl->tpl_vars['userRoles']->value[$_smarty_tpl->tpl_vars['user']->value['id']])) {?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['userRoles']->value[$_smarty_tpl->tpl_vars['user']->value['id']], 'ur');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ur']->value) {
?>
                            <span class="tag tag-role"><?php echo $_smarty_tpl->tpl_vars['ur']->value['name'];?>
</span>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php } else { ?>
                            <span style="color:#999;">未分配</span>
                        <?php }?>
                    </td>
                    <td>
                        <form action="/" method="post" style="display:flex; align-items:center; gap:8px;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="a" value="assignRole">
                            <input type="hidden" name="admin_id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <div class="role-checkbox-group">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roles']->value, 'role');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['role']->value) {
?>
                                <label>
                                    <input type="checkbox" name="role_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
"
                                        <?php if (isset($_smarty_tpl->tpl_vars['userRoles']->value[$_smarty_tpl->tpl_vars['user']->value['id']])) {?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['userRoles']->value[$_smarty_tpl->tpl_vars['user']->value['id']], 'ur');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ur']->value) {
?>
                                                <?php if ($_smarty_tpl->tpl_vars['ur']->value['id'] == $_smarty_tpl->tpl_vars['role']->value['id']) {?>checked<?php }?>
                                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        <?php }?>>
                                    <?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>

                                </label>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                            <input class="input-sub input-sub-sm" type="submit" value="保存">
                        </form>
                    </td>
                </tr>
                <?php }?>
                <?php
}
} else {
?>
                <tr><td colspan="4" style="text-align:center;color:#999;padding:40px;">暂无管理员用户</td></tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </table>

            <?php if ($_smarty_tpl->tpl_vars['totalPages']->value > 1) {?>
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['prevPage']->value;?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
 页</span>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['nextPage']->value;?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="post" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="PermissionA">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                        </form>
                    </div>
                </div>
            <?php }?>
        </article>
    </div>
</div>
</body>
</html>
<?php }
}
