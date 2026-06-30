<?php
/* Smarty version 3.1.32, created on 2026-06-25 09:17:46
  from '/home/sky/www/app/admin/view/backup.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3cf23a0b2880_95158647',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'abb3270a2d0ff7a3149e552a8f96a008dd500fda' => 
    array (
      0 => '/home/sky/www/app/admin/view/backup.php',
      1 => 1782377776,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3cf23a0b2880_95158647 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据备份与恢复 - 后台管理系统</title>
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
        .action-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-bottom: 20px; }
        .action-card h3 { margin: 0 0 10px 0; font-size: 15px; }
        .action-card p { font-size: 13px; color: #666; margin: 0 0 10px 0; }
        .backup-table { width: 100%; border-collapse: collapse; }
        .backup-table th, .backup-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .backup-table th { background: #f2f2f2; font-weight: bold; }
        .backup-table tr:hover { background: #f5f7fa; }
        .btn { display: inline-block; padding: 6px 15px; border-radius: 4px; font-size: 13px; text-decoration: none; cursor: pointer; border: none; }
        .btn-primary { background: #409eff; color: #fff; }
        .btn-primary:hover { background: #337ecc; }
        .btn-danger { background: #f56c6c; color: #fff; }
        .btn-danger:hover { background: #d9534f; }
        .btn-warning { background: #e6a23c; color: #fff; }
        .btn-warning:hover { background: #cf9236; }
        .btn-success { background: #67c23a; color: #fff; }
        .btn-success:hover { background: #5daf34; }
        .btn-sm { padding: 3px 8px; font-size: 12px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
        .modal-box { background: #fff; border-radius: 8px; padding: 25px; width: 420px; max-width: 90%; }
        .modal-box h3 { margin: 0 0 5px 0; font-size: 16px; }
        .modal-box p { font-size: 13px; color: #666; margin: 5px 0 15px 0; }
        .modal-box input[type="text"] { width: 100%; padding: 8px 10px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
        .modal-box .btn { margin-top: 10px; }
        .modal-box .btn + .btn { margin-left: 8px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-size: 13px; color: #666; margin-bottom: 4px; }
        .form-group input, .form-group textarea { width: 100%; padding: 6px 10px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; box-sizing: border-box; }
        .form-group textarea { resize: vertical; min-height: 60px; }
        .form-inline { display: flex; gap: 10px; align-items: flex-end; }
        .form-inline .form-group { flex: 1; }
        .text-warning { color: #e6a23c; }
        .text-muted { color: #999; }
        .text-right { text-align: right; }
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
            <div class="text"><h2>数据备份与恢复</h2></div>

            <?php if ($_SESSION['success_msg'] != '') {?>
                <div class="msg-success"><?php echo $_SESSION['success_msg'];?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 5000);<?php echo '</script'; ?>
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
>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 5000);<?php echo '</script'; ?>
>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['_SESSION']) ? $_smarty_tpl->tpl_vars['_SESSION']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['error_msg'] = '';
$_smarty_tpl->_assignInScope('_SESSION', $_tmp_array);?>
            <?php }?>

            <div class="action-card">
                <h3>创建新备份</h3>
                <p>备份当前数据库 (MySQL dump, 自动压缩为 .sql.gz)</p>
                <form action="/" method="post">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="DataBR">
                    <input type="hidden" name="a" value="create">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <div class="form-inline">
                        <div class="form-group">
                            <label>备注 (可选)</label>
                            <input type="text" name="note" placeholder="例如: 更新前备份" maxlength="200">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('确定创建新备份？')">立即备份</button>
                    </div>
                </form>
            </div>

            <div class="action-card">
                <h3>备份列表</h3>
                <?php if (count($_smarty_tpl->tpl_vars['backups']->value) > 0) {?>
                    <table class="backup-table">
                        <tr>
                            <th>文件名</th>
                            <th>大小</th>
                            <th>创建时间</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['backups']->value, 'b');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['b']->value) {
?>
                        <tr>
                            <td style="font-family:monospace;font-size:12px;"><?php echo $_smarty_tpl->tpl_vars['b']->value['filename'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['backupService']->value->formatSize($_smarty_tpl->tpl_vars['b']->value['size']);?>
</td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['b']->value['created_at'];?>
</small></td>
                            <td><small><?php echo (($tmp = @$_smarty_tpl->tpl_vars['b']->value['note'])===null||$tmp==='' ? '-' : $tmp);?>
</small></td>
                            <td nowrap>
                                <a href="index.php?p=admin&c=DataBR&a=download&file=<?php echo urlencode($_smarty_tpl->tpl_vars['b']->value['filename']);?>
" class="btn btn-success btn-sm">下载</a>
                                <button onclick="showRestoreModal('<?php echo $_smarty_tpl->tpl_vars['b']->value['filename'];?>
')" class="btn btn-warning btn-sm">恢复</button>
                                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定删除该备份？')">
                                    <input type="hidden" name="p" value="admin">
                                    <input type="hidden" name="c" value="DataBR">
                                    <input type="hidden" name="a" value="delete">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <input type="hidden" name="filename" value="<?php echo $_smarty_tpl->tpl_vars['b']->value['filename'];?>
">
                                    <button type="submit" class="btn btn-danger btn-sm">删除</button>
                                </form>
                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </table>
                <?php } else { ?>
                    <div style="text-align:center;padding:30px;color:#999;">暂无备份文件</div>
                <?php }?>
            </div>
        </article>
    </div>
</div>

<div id="restoreModal" class="modal-overlay">
    <div class="modal-box">
        <h3>恢复数据库</h3>
        <p>警告：恢复操作将<strong>覆盖</strong>当前数据库的所有数据，此操作不可撤销！</p>
        <p>请输入 <code>CONFIRM_RESTORE</code> 确认恢复：</p>
        <form action="/" method="post" onsubmit="return document.getElementById('confirm_input').value === 'CONFIRM_RESTORE'">
            <input type="hidden" name="p" value="admin">
            <input type="hidden" name="c" value="DataBR">
            <input type="hidden" name="a" value="restore">
            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
            <input type="hidden" name="filename" id="restore_filename" value="">
            <input type="text" id="confirm_input" placeholder="输入 CONFIRM_RESTORE" autocomplete="off">
            <div>
                <button type="button" onclick="hideRestoreModal()" class="btn btn-primary" style="background:#999;">取消</button>
                <button type="submit" class="btn btn-danger">确认恢复</button>
            </div>
        </form>
    </div>
</div>

<?php echo '<script'; ?>
>
function showRestoreModal(filename) {
    document.getElementById('restore_filename').value = filename;
    document.getElementById('restoreModal').style.display = 'flex';
}
function hideRestoreModal() {
    document.getElementById('restoreModal').style.display = 'none';
    document.getElementById('confirm_input').value = '';
}
window.onclick = function(e) {
    if (e.target === document.getElementById('restoreModal')) {
        hideRestoreModal();
    }
};
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
