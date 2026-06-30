<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:56:18
  from '/home/sky/www/app/admin/view/logs.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced32e3cd34_89832092',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f25e2070d69fa652577adf263b7442abf72a1e92' => 
    array (
      0 => '/home/sky/www/app/admin/view/logs.php',
      1 => 1782377773,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced32e3cd34_89832092 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sky/www/vendor/smarty/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
?><!DOCTYPE html>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
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
                    <h2>操作日志</h2>
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

                <div class="toolbar">
                    <a href="index.php?p=admin&c=Log&a=export&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
" class="btn btn-default btn-sm" style="float:right; margin-left:8px;">导出CSV</a>
                    <form action="/" method="post" style="display:inline; float:right;" onsubmit="return confirm('确定要清理日志吗？建议先导出备份。')">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Log">
                        <input type="hidden" name="a" value="clean">
                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
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
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['modules']->value, 'mod');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mod']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['mod']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['filters']->value['module'] == $_smarty_tpl->tpl_vars['mod']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['mod']->value;?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <input type="text" name="username" placeholder="用户名" value="<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
">
                    <input type="date" name="date_from" value="<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
" placeholder="开始日期">
                    <input type="date" name="date_to" value="<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
" placeholder="结束日期">
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
                    <?php if (count($_smarty_tpl->tpl_vars['logs']->value) == 0) {?>
                        <tr><td colspan="8" class="text-center text-muted">暂无日志</td></tr>
                    <?php } else { ?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['logs']->value, 'log');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['log']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['log']->value['id'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['log']->value['username']) {
echo $_smarty_tpl->tpl_vars['log']->value['username'];
} else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['log']->value['module']) {?><span class="badge"><?php echo $_smarty_tpl->tpl_vars['log']->value['module'];?>
</span><?php } else { ?>-<?php }?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['log']->value['action'];?>
</td>
                            <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?php echo $_smarty_tpl->tpl_vars['log']->value['detail'];?>
"><?php if ($_smarty_tpl->tpl_vars['log']->value['detail']) {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['log']->value['detail'],40);
} else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['log']->value['ip_address']) {
echo $_smarty_tpl->tpl_vars['log']->value['ip_address'];
} else { ?>-<?php }?></td>
                            <td style="font-size:12px;"><?php echo $_smarty_tpl->tpl_vars['log']->value['created_at'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['log']->value['status'] == '1') {?><span class="log-success">成功</span><?php } else { ?><span class="log-failed" title="<?php echo $_smarty_tpl->tpl_vars['log']->value['error_msg'];?>
">失败</span><?php }?></td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                </table>

                <?php if ($_smarty_tpl->tpl_vars['totalPages']->value > 1) {?>
                    <div class="pagination">
                        <?php if ($_smarty_tpl->tpl_vars['page']->value > 1) {?>
                            <a href="index.php?p=admin&c=Log&a=index&page=1&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&username=<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
&status=<?php echo $_smarty_tpl->tpl_vars['filters']->value['status'];?>
">首页</a>
                            <a href="index.php?p=admin&c=Log&a=index&page=<?php echo $_smarty_tpl->tpl_vars['prevPage']->value;?>
&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&username=<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
&status=<?php echo $_smarty_tpl->tpl_vars['filters']->value['status'];?>
">上一页</a>
                        <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? min($_smarty_tpl->tpl_vars['totalPages']->value,$_smarty_tpl->tpl_vars['page']->value+2)+1 - (max(1,$_smarty_tpl->tpl_vars['page']->value-2)) : max(1,$_smarty_tpl->tpl_vars['page']->value-2)-(min($_smarty_tpl->tpl_vars['totalPages']->value,$_smarty_tpl->tpl_vars['page']->value+2))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = max(1,$_smarty_tpl->tpl_vars['page']->value-2), $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                            <?php if ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['page']->value) {?>
                                <span class="active"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</span>
                            <?php } else { ?>
                                <a href="index.php?p=admin&c=Log&a=index&page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&username=<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
&status=<?php echo $_smarty_tpl->tpl_vars['filters']->value['status'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            <?php }?>
                        <?php }
}
?>
                        <?php if ($_smarty_tpl->tpl_vars['page']->value < $_smarty_tpl->tpl_vars['totalPages']->value) {?>
                            <a href="index.php?p=admin&c=Log&a=index&page=<?php echo $_smarty_tpl->tpl_vars['nextPage']->value;?>
&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&username=<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
&status=<?php echo $_smarty_tpl->tpl_vars['filters']->value['status'];?>
">下一页</a>
                            <a href="index.php?p=admin&c=Log&a=index&page=<?php echo $_smarty_tpl->tpl_vars['totalPages']->value;?>
&module=<?php echo $_smarty_tpl->tpl_vars['filters']->value['module'];?>
&username=<?php echo $_smarty_tpl->tpl_vars['filters']->value['username'];?>
&date_from=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_from'];?>
&date_to=<?php echo $_smarty_tpl->tpl_vars['filters']->value['date_to'];?>
&status=<?php echo $_smarty_tpl->tpl_vars['filters']->value['status'];?>
">尾页</a>
                        <?php }?>
                    </div>
                    <div class="text-center text-muted" style="margin-top:8px; font-size:13px;">共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条日志</div>
                <?php }?>
            </article>
        </div>
    </div>
</body>
</html>
<?php }
}
