<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:56:23
  from '/home/sky/www/app/admin/view/tool.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced37839380_17536038',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4299bfa57668e085a6d3d40decc31f09e9bbff50' => 
    array (
      0 => '/home/sky/www/app/admin/view/tool.php',
      1 => 1782377771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced37839380_17536038 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sky/www/vendor/smarty/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>优化工具 - 后台管理系统</title>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"><?php echo '</script'; ?>
>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 22px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .stat-card .stat-sub { font-size: 11px; color: #bbb; margin-top: 2px; }
        .stat-blue .stat-value { color: #409eff; } .stat-green .stat-value { color: #67c23a; }
        .stat-orange .stat-value { color: #e6a23c; } .stat-red .stat-value { color: #f56c6c; }
        .score-meter { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold; margin: 0 auto 5px; }
        .grade-A { background: #67c23a; color: #fff; } .grade-B { background: #409eff; color: #fff; }
        .grade-C { background: #e6a23c; color: #fff; } .grade-D { background: #f56c6c; color: #fff; }
        .chart-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-bottom: 20px; }
        .chart-box h3 { margin: 0 0 10px 0; font-size: 15px; }
        .chart-container { width: 100%; height: 250px; }
        .card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-bottom: 20px; }
        .card h3 { margin: 0 0 10px 0; font-size: 15px; }
        .half-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .info-table th, .info-table td { padding: 6px 10px; border: 1px solid #e6e6e6; text-align: left; }
        .info-table th { background: #f2f2f2; width: 130px; }
        .info-table tr:hover { background: #f5f7fa; }
        .scroll-box { max-height: 250px; overflow-y: auto; }
        .btn { display: inline-block; padding: 6px 15px; border-radius: 4px; font-size: 13px; text-decoration: none; cursor: pointer; border: none; }
        .btn-primary { background: #409eff; color: #fff; } .btn-primary:hover { background: #337ecc; }
        .btn-danger { background: #f56c6c; color: #fff; } .btn-danger:hover { background: #d9534f; }
        .btn-success { background: #67c23a; color: #fff; } .btn-success:hover { background: #5daf34; }
        .tag { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
        .tag-high { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-medium { background: #fdf6ec; color: #e6a23c; border: 1px solid #faecd8; }
        .tag-low { background: #ecf5ff; color: #409eff; border: 1px solid #d9ecff; }
        .tag-info { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .action-bar { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px; }
        .issue-item { border-left: 3px solid; padding: 8px 12px; margin-bottom: 6px; background: #f8f9fa; border-radius: 0 4px 4px 0; font-size: 12px; }
        .issue-high { border-color: #f56c6c; } .issue-medium { border-color: #e6a23c; } .issue-low { border-color: #409eff; } .issue-info { border-color: #909399; }
        .error-log-box { max-height: 200px; overflow-y: auto; font-size: 11px; background: #1e1e1e; color: #ccc; font-family: monospace; border-radius: 4px; padding: 10px; }
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
            <div class="text"><h2>优化工具</h2></div>

            <?php if ($_SESSION['success_msg'] != '') {?>
                <div class="msg-success"><?php echo $_SESSION['success_msg'];?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 4000);<?php echo '</script'; ?>
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
>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 4000);<?php echo '</script'; ?>
>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['_SESSION']) ? $_smarty_tpl->tpl_vars['_SESSION']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['error_msg'] = '';
$_smarty_tpl->_assignInScope('_SESSION', $_tmp_array);?>
            <?php }?>

            <div class="action-bar">
                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定优化所有数据表？')">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Tool">
                    <input type="hidden" name="a" value="optimize">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <button type="submit" class="btn btn-success">优化所有数据表</button>
                </form>
                <form action="/" method="post" style="display:inline;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Tool">
                    <input type="hidden" name="a" value="clearPhpCache">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <button type="submit" class="btn btn-primary">重置 OPCache</button>
                </form>
            </div>

            <div class="stats-grid">
                <div class="stat-card" style="padding:10px;">
                    <div class="score-meter grade-<?php echo $_smarty_tpl->tpl_vars['scoreInfo']->value['grade'];?>
"><?php echo $_smarty_tpl->tpl_vars['scoreInfo']->value['score'];?>
</div>
                    <div class="stat-label">性能评分</div>
                    <div class="stat-sub" style="font-size:11px;color:#999;">等级 <?php echo $_smarty_tpl->tpl_vars['scoreInfo']->value['grade'];?>
</div>
                </div>
                <div class="stat-card stat-blue"><div class="stat-value"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['cpu']['load_pct'])===null||$tmp==='' ? 'N/A' : $tmp);
if ($_smarty_tpl->tpl_vars['system']->value['cpu']['load_pct']) {?>%<?php }?></div><div class="stat-label">CPU 使用率</div><div class="stat-sub">1min: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['cpu']['1min'])===null||$tmp==='' ? '-' : $tmp);?>
 | 核心: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['cpu']['cores'])===null||$tmp==='' ? '-' : $tmp);?>
</div></div>
                <div class="stat-card stat-green"><div class="stat-value"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['memory']['usage_pct'])===null||$tmp==='' ? 'N/A' : $tmp);
if ($_smarty_tpl->tpl_vars['system']->value['memory']['usage_pct']) {?>%<?php }?></div><div class="stat-label">内存使用率</div><div class="stat-sub"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['memory']['used_mb'])===null||$tmp==='' ? '?' : $tmp);?>
/<?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['memory']['total_mb'])===null||$tmp==='' ? '?' : $tmp);?>
 MB</div></div>
                <div class="stat-card stat-orange"><div class="stat-value"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['disk']['usage_pct'])===null||$tmp==='' ? 'N/A' : $tmp);
if ($_smarty_tpl->tpl_vars['system']->value['disk']['usage_pct']) {?>%<?php }?></div><div class="stat-label">磁盘使用率</div><div class="stat-sub"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['disk']['used_gb'])===null||$tmp==='' ? '?' : $tmp);?>
/<?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['disk']['total_gb'])===null||$tmp==='' ? '?' : $tmp);?>
 GB</div></div>
            </div>

            <div class="half-grid">
                <div class="chart-box">
                    <h3>页面响应时间趋势 (近7天)</h3>
                    <div id="responseChart" class="chart-container"></div>
                </div>
                <div class="card">
                    <h3>优化建议</h3>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['optimizationTips']->value, 'tip');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tip']->value) {
?>
                    <div class="issue-item issue-<?php echo $_smarty_tpl->tpl_vars['tip']->value['severity'];?>
">
                        <strong><?php echo $_smarty_tpl->tpl_vars['tip']->value['title'];?>
</strong><br>
                        <span style="color:#666;"><?php echo $_smarty_tpl->tpl_vars['tip']->value['desc'];?>
</span>
                        <?php if ($_smarty_tpl->tpl_vars['tip']->value['fix']) {?><br><small style="color:#409eff;"><?php echo $_smarty_tpl->tpl_vars['tip']->value['fix'];?>
</small><?php }?>
                    </div>
                    <?php
}
} else {
?>
                    <p style="color:#999;text-align:center;padding:20px;">暂无优化建议</p>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </div>
            </div>

            <div class="half-grid">
                <div class="card">
                    <h3>PHP 配置</h3>
                    <table class="info-table">
                        <tr><th>版本</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['php']['version'];?>
</td></tr>
                        <tr><th>内存限制</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['php']['memory_limit'];?>
</td></tr>
                        <tr><th>执行时间</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['php']['max_exec_time'];?>
</td></tr>
                        <tr><th>上传限制</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['php']['upload_max'];?>
</td></tr>
                        <tr><th>OPCache</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['php']['opcache'];?>
</td></tr>
                        <tr><th>服务器</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['server']['name'];?>
</td></tr>
                        <tr><th>系统</th><td><?php echo $_smarty_tpl->tpl_vars['system']->value['server']['os'];?>
</td></tr>
                        <tr><th>运行时间</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['system']->value['server']['uptime'])===null||$tmp==='' ? '-' : $tmp);?>
</td></tr>
                    </table>
                </div>
                <div class="card">
                    <h3>数据库状态</h3>
                    <table class="info-table">
                        <tr><th>总查询数</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['queries_total'])===null||$tmp==='' ? '-' : $tmp);?>
</td></tr>
                        <tr><th>慢查询</th><td><span style="color:<?php if ($_smarty_tpl->tpl_vars['dbStatus']->value['slow_queries'] > 100) {?>#f56c6c<?php } else { ?>#67c23a<?php }?>;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['slow_queries'])===null||$tmp==='' ? 0 : $tmp);?>
</span></td></tr>
                        <tr><th>活跃连接</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['active_connections'])===null||$tmp==='' ? 0 : $tmp);?>
</td></tr>
                        <tr><th>长运行查询</th><td><?php if ($_smarty_tpl->tpl_vars['dbStatus']->value['long_running'] > 0) {?><span style="color:#f56c6c;"><?php echo $_smarty_tpl->tpl_vars['dbStatus']->value['long_running'];?>
</span><?php } else { ?>0<?php }?></td></tr>
                        <tr><th>数据库大小</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['db_size_mb'])===null||$tmp==='' ? 0 : $tmp);?>
 MB</td></tr>
                        <tr><th>表数量</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['table_count'])===null||$tmp==='' ? 0 : $tmp);?>
</td></tr>
                        <tr><th>慢查询日志</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['dbStatus']->value['slow_query_log'])===null||$tmp==='' ? 'N/A' : $tmp);?>
</td></tr>
                    </table>
                </div>
            </div>

            <?php if (count($_smarty_tpl->tpl_vars['slowQueries']->value) > 0) {?>
            <div class="card">
                <h3>慢查询 (运行 &gt; 2s)</h3>
                <div class="scroll-box">
                    <table class="info-table" style="font-size:12px;">
                        <tr><th>时间</th><th>用户</th><th>SQL</th></tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['slowQueries']->value, 'q');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['q']->value) {
?>
                        <tr>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['q']->value['Time'];?>
s</small></td>
                            <td><small><?php echo (($tmp = @$_smarty_tpl->tpl_vars['q']->value['User'])===null||$tmp==='' ? '-' : $tmp);?>
</small></td>
                            <td style="max-width:400px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['q']->value['Info'])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'ISO-8859-1', true);?>
"><small><?php echo smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['q']->value['Info'])===null||$tmp==='' ? '' : $tmp),60);?>
</small></td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </table>
                </div>
            </div>
            <?php }?>

            <?php if (is_array($_smarty_tpl->tpl_vars['errors']->value) && (($tmp = @$_smarty_tpl->tpl_vars['errors']->value['error'])===null||$tmp==='' ? '' : $tmp) == '') {?>
            <div class="card">
                <h3>最近 PHP 错误</h3>
                <div class="error-log-box">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors']->value, 'line');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
?>
                    <div><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value, ENT_QUOTES, 'ISO-8859-1', true);?>
</div>
                    <?php
}
} else {
?>
                    <div style="color:#67c23a;">无错误日志</div>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </div>
            </div>
            <?php }?>

            <div class="card">
                <h3>数据表状态</h3>
                <div class="scroll-box">
                    <table class="info-table" style="font-size:12px;">
                        <tr><th>表名</th><th>引擎</th><th>行数</th><th>数据</th><th>索引</th><th>总大小</th><th>整理碎片</th></tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tables']->value, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
?>
                        <tr>
                            <td style="font-family:monospace;"><?php echo $_smarty_tpl->tpl_vars['t']->value['name'];?>
</td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['engine'];?>
</small></td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['rows'];?>
</small></td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['data_size'];?>
</small></td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['index_size'];?>
</small></td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['total_size'];?>
</small></td>
                            <td><small><?php echo $_smarty_tpl->tpl_vars['t']->value['overhead'];?>
</small></td>
                        </tr>
                        <?php
}
} else {
?>
                        <tr><td colspan="7" style="text-align:center;color:#999;padding:20px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['tables']->value['error'])===null||$tmp==='' ? '暂无数据' : $tmp);?>
</td></tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </table>
                </div>
            </div>
        </article>
    </div>
</div>

<?php echo '<script'; ?>
>
var responseChart = echarts.init(document.getElementById('responseChart'));
responseChart.setOption({
    tooltip: { trigger: 'axis' },
    legend: { data: ['平均响应', '最大响应'] },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: { type: 'category', data: <?php echo $_smarty_tpl->tpl_vars['rtLabels']->value;?>
 },
    yAxis: { type: 'value', name: 'ms' },
    series: [
        { name: '平均响应', type: 'line', smooth: true, data: <?php echo $_smarty_tpl->tpl_vars['rtAvg']->value;?>
, color: '#409eff', areaStyle: { color: 'rgba(64,158,255,0.1)' } },
        { name: '最大响应', type: 'line', smooth: true, data: <?php echo $_smarty_tpl->tpl_vars['rtMax']->value;?>
, color: '#f56c6c', lineStyle: { type: 'dashed' } }
    ]
});
window.addEventListener('resize', function(){ responseChart.resize(); });
<?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
