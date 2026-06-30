<?php
/* Smarty version 3.1.32, created on 2026-06-25 09:23:25
  from '/home/sky/www/app/admin/view/user.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3cf38d9d1126_11773152',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f28e8f1f3925c43b772a25d049e3dec98685114b' => 
    array (
      0 => '/home/sky/www/app/admin/view/user.php',
      1 => 1782377772,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3cf38d9d1126_11773152 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sky/www/vendor/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?><!DOCTYPE html>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
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
                <div class="text">
                    <h2>用户管理</h2>
                    <form action="/" method="post" style="display:inline;">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="User">
                        <input type="hidden" name="a" value="add">
                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                        <input class="input-sub" type="submit" value="新增用户">
                    </form>
                </div>

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

                <?php if (isset($_smarty_tpl->tpl_vars['editMode']->value) && $_smarty_tpl->tpl_vars['editMode']->value) {?>
                    <div class="text"><h3><?php if ($_smarty_tpl->tpl_vars['editUser']->value['id']) {?>编辑用户<?php } else { ?>新增用户<?php }?></h3></div>
                    <div class="user-form">
                        <?php if ($_smarty_tpl->tpl_vars['error']->value != '') {?>
                            <div class="msg-error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
                        <?php }?>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="User">
                            <input type="hidden" name="a" value="<?php if ($_smarty_tpl->tpl_vars['editUser']->value['id']) {?>edit<?php } else { ?>add<?php }?>">
                            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['editUser']->value['id'];?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <div class="field">
                                <label>用户名</label>
                                <input type="text" name="username" value="<?php echo $_smarty_tpl->tpl_vars['editUser']->value['username'];?>
" required>
                            </div>
                            <div class="field">
                                <label>密码 <?php if ($_smarty_tpl->tpl_vars['editUser']->value['id']) {?><span style="color:#999;font-size:12px;">(留空则不修改)</span><?php }?></label>
                                <input type="password" name="password" <?php if (!$_smarty_tpl->tpl_vars['editUser']->value['id']) {?>required<?php }?>>
                            </div>
                            <div class="field">
                                <label>权限</label>
                                <select name="is_admin">
                                    <option value="0" <?php if ($_smarty_tpl->tpl_vars['editUser']->value['is_admin'] == '0') {?>selected<?php }?>>普通用户</option>
                                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['editUser']->value['is_admin'] == '1') {?>selected<?php }?>>管理员</option>
                                </select>
                            </div>
                            <div class="field">
                                <input class="input-sub" type="submit" value="保存">
                                <a href="/index.php?p=admin&c=User&a=index" style="margin-left:10px;color:#409eff;">返回</a>
                            </div>
                        </form>
                    </div>
                <?php } else { ?>
                    <table class="user-table">
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>权限</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['item']->value['is_admin'] == '1') {?>管理员<?php } else { ?>普通用户<?php }?></td>
                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['reg_time'],"%Y-%m-%d %H:%M");?>
</td>
                            <td>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="a" value="edit">
                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <button type="submit" class="btn-edit">编辑</button>
                                </form>
                                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定要删除用户 <?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
 吗？');">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="a" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <button type="submit" class="btn-del">删除</button>
                                </form>
                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </table>

                    <?php if ($_smarty_tpl->tpl_vars['totalPages']->value > 1) {?>
                        <div class="kg-pager">
                            <div class="layui-box layui-laypage">
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="1">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                                </form>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
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
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['nextPage']->value;?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                                </form>
                                <form action="/" method="post" style="display:inline;">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="User">
                                    <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                                </form>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>
            </article>
        </div>
    </div>
</body>
</html>
<?php }
}
