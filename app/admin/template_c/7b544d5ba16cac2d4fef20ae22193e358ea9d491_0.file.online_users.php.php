<?php
/* Smarty version 3.1.32, created on 2026-06-25 09:16:07
  from '/home/sky/www/app/admin/view/online_users.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3cf1d7d743b9_46836849',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b544d5ba16cac2d4fef20ae22193e358ea9d491' => 
    array (
      0 => '/home/sky/www/app/admin/view/online_users.php',
      1 => 1782377779,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3cf1d7d743b9_46836849 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线用户管理 - 后台管理系统</title>
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
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 26px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .stat-red .stat-value { color: #f56c6c; } .stat-blue .stat-value { color: #409eff; }
        .stat-green .stat-value { color: #67c23a; } .stat-orange .stat-value { color: #e6a23c; }
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th, .user-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .user-table th { background: #f2f2f2; font-weight: bold; }
        .user-table tr:hover { background: #f5f7fa; }
        .filter-bar { margin-bottom: 15px; padding: 12px; background: #fafafa; border: 1px solid #e6e6e6; border-radius: 4px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .filter-bar select, .filter-bar input { padding: 5px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; }
        .filter-bar .input-sub { font-size: 13px; padding: 5px 12px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .tag { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-guest { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .btn-kick { color: #f56c6c; cursor: pointer; background: none; border: 1px solid #f56c6c; border-radius: 3px; font-size: 12px; padding: 2px 8px; }
        .btn-kick:hover { background: #fef0f0; }
        .btn-detail { color: #409eff; cursor: pointer; background: none; border: 1px solid #409eff; border-radius: 3px; font-size: 12px; padding: 2px 8px; text-decoration: none; }
        .btn-detail:hover { background: #ecf5ff; }
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
                <h2>在线用户管理</h2>
                <a href="index.php?p=admin&c=OnlineUser&a=history" style="font-size:13px;color:#409eff;margin-left:10px;">登录历史 &raquo;</a>
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

            <div class="stats-grid">
                <div class="stat-card stat-blue"><div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['overview']->value['total_online'];?>
</div><div class="stat-label">总在线</div></div>
                <div class="stat-card stat-red"><div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['overview']->value['admin_online'];?>
</div><div class="stat-label">管理员</div></div>
                <div class="stat-card stat-green"><div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['overview']->value['user_online'];?>
</div><div class="stat-label">注册用户</div></div>
                <div class="stat-card stat-orange"><div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['overview']->value['guest_online'];?>
</div><div class="stat-label">游客</div></div>
                <div class="stat-card stat-blue"><div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['overview']->value['unique_ips'];?>
</div><div class="stat-label">独立IP</div></div>
            </div>

            <div class="filter-bar">
                <form action="/" method="get" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="OnlineUser">
                    <input type="hidden" name="a" value="index">
                    <select name="user_type">
                        <option value="">全部类型</option>
                        <option value="admin" <?php if ($_smarty_tpl->tpl_vars['filters']->value['user_type'] == 'admin') {?>selected<?php }?>>管理员</option>
                        <option value="user" <?php if ($_smarty_tpl->tpl_vars['filters']->value['user_type'] == 'user') {?>selected<?php }?>>用户</option>
                    </select>
                    <input type="text" name="username" placeholder="用户名" value="<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
" style="width:120px;">
                    <input type="text" name="ip_address" placeholder="IP地址" value="<?php echo $_smarty_tpl->tpl_vars['filters']->value['ip_address'];?>
" style="width:130px;">
                    <input class="input-sub" type="submit" value="筛选" style="font-size:13px;padding:5px 12px;">
                    <a href="index.php?p=admin&c=OnlineUser" style="font-size:13px;color:#999;">重置</a>
                </form>
            </div>

            <table class="user-table">
                <tr>
                    <th>Session ID</th>
                    <th>类型</th>
                    <th>用户名</th>
                    <th>IP地址</th>
                    <th>最后活动</th>
                    <th>登录时间</th>
                    <th>操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['onlineUsers']->value, 'u');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
?>
                <tr>
                    <td style="font-family:monospace;font-size:11px;"><?php echo substr($_smarty_tpl->tpl_vars['u']->value['session_id'],0,16);?>
...</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['u']->value['user_type'] == 'admin') {?><span class="tag tag-admin">管理员</span><?php } elseif ($_smarty_tpl->tpl_vars['u']->value['user_type'] == 'user') {?><span class="tag tag-user">用户</span><?php } else { ?><span class="tag tag-guest">游客</span><?php }?></td>
                    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['u']->value['username'])===null||$tmp==='' ? '<em style="color:#999;">游客</em>' : $tmp);?>
</td>
                    <td><small><?php echo $_smarty_tpl->tpl_vars['u']->value['ip_address'];?>
</small></td>
                    <td><small><?php echo $_smarty_tpl->tpl_vars['u']->value['last_activity'];?>
</small></td>
                    <td><small><?php echo (($tmp = @$_smarty_tpl->tpl_vars['u']->value['login_time'])===null||$tmp==='' ? '-' : $tmp);?>
</small></td>
                    <td>
                        <a href="index.php?p=admin&c=OnlineUser&a=detail&session_id=<?php echo urlencode($_smarty_tpl->tpl_vars['u']->value['session_id']);?>
" class="btn-detail">详情</a>
                        <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定踢出该用户？')">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="a" value="kick">
                            <input type="hidden" name="session_id" value="<?php echo $_smarty_tpl->tpl_vars['u']->value['session_id'];?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <button type="submit" class="btn-kick">踢出</button>
                        </form>
                    </td>
                </tr>
                <?php
}
} else {
?>
                <tr><td colspan="7" style="text-align:center;color:#999;padding:30px;">暂无在线用户</td></tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </table>

            <?php if ($_smarty_tpl->tpl_vars['totalPages']->value > 1) {?>
                <div class="kg-pager">
                    <div class="layui-box layui-laypage">
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="1">
                            <a href="/" onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['prevPage']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">上页</a>
                        </form>
                        <span>第 <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
 页</span>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['nextPage']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">下页</a>
                        </form>
                        <form action="/" method="get" style="display:inline;">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="OnlineUser">
                            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
">
                            <a href="/" onclick="this.parentNode.submit(); return false;">尾页</a>
                        </form>
                    </div>
                </div>
            <?php }?>
            <div style="text-align:center;color:#999;font-size:12px;margin-top:10px;">共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条记录</div>
        </article>
    </div>
</div>
</body>
</html>
<?php }
}
