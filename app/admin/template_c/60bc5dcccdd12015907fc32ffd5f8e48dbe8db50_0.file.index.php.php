<?php
/* Smarty version 3.1.32, created on 2026-06-25 10:30:38
  from '/home/sky/www/app/admin/view/index.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3d034e03ba85_58310005',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60bc5dcccdd12015907fc32ffd5f8e48dbe8db50' => 
    array (
      0 => '/home/sky/www/app/admin/view/index.php',
      1 => 1782383432,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3d034e03ba85_58310005 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/highcharts.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
    <style>
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; text-align: center; cursor: pointer; transition: all .3s; text-decoration: none; color: #333; display: block; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }
        .stat-card .stat-icon { font-size: 32px; margin-bottom: 10px; }
        .stat-card .stat-value { font-size: 28px; font-weight: bold; margin: 10px 0; }
        .stat-card .stat-label { font-size: 13px; color: #999; }

        .chart-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        @media (max-width: 900px) { .chart-row { grid-template-columns: 1fr; } }
        .chart-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; }
        .chart-box h3 { margin: 0 0 10px 0; font-size: 15px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 8px; }
        .chart-box .chart-container { height: 300px; }

        .quick-actions { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-bottom: 25px; }
        .quick-action { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; cursor: pointer; transition: all .3s; text-decoration: none; color: #333; display: block; }
        .quick-action:hover { background: #f5f7fa; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }
        .quick-action .action-icon { font-size: 24px; margin-bottom: 8px; display: block; }
        .quick-action .action-label { font-size: 13px; }

        .recent-logs { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; margin-bottom: 25px; }
        .recent-logs h3 { margin: 0 0 10px 0; font-size: 15px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 8px; }
        .log-table { width: 100%; font-size: 13px; border-collapse: collapse; }
        .log-table th { background: #f5f7fa; padding: 8px 10px; text-align: left; font-weight: normal; color: #666; border-bottom: 2px solid #e4e7ed; }
        .log-table td { padding: 6px 10px; border-bottom: 1px solid #f2f2f2; }
        .log-table tr:hover td { background: #f5f7fa; }
        .status-success { color: #67c23a; }
        .status-failed { color: #f56c6c; }

        .system-status { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; }
        @media (max-width: 768px) { .system-status { grid-template-columns: 1fr; } }
        .status-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; }
        .status-box h3 { margin: 0 0 10px 0; font-size: 15px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 8px; }
        .status-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #fafafa; font-size: 13px; }
        .status-item:last-child { border-bottom: none; }
        .status-label { color: #666; }
        .status-value { font-weight: bold; color: #333; }

        .loading-placeholder { text-align: center; padding: 40px; color: #999; }
        .loading-placeholder i { font-size: 32px; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>
    <div id="container" >
        <header>
            <div class="nav_left">
                <ul>
                    <li>后台管理系统</li>
                </ul>
            </div>
            <div class="nav_middle">
                <ul>
                    <li>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Index">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/"  onclick="this.parentNode.submit(); return false;">首页</a>
                        </form>
                    </li>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MainTitledata']->value, 'item', false, NULL, 'loop', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index']++;
?>
                        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index'] : null) < 4) {?>
                    <li>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['types'];?>
">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <a href="/"  onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['item']->value['course'];?>
</a>
                        </form>
                    </li>
                        <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
            </div>
            <div class="nav_right">
                <li ><a href="/">前台首页</a></li>
                <li ><a href="#">管理员：<?php echo $_smarty_tpl->tpl_vars['session_username']->value;?>
</a></li>
                <li ><a href="index.php?p=admin&c=Auth&a=logout">退出登录</a></li>
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
                        <dl class="subtitle" >
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
                                                <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                                <a href="/"  onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['subitem']->value['subject'];?>
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
                <?php if ($_smarty_tpl->tpl_vars['C']->value == 'Index') {?>
                    <div class="text"><h2>后台管理仪表盘</h2></div>

                    <div class="stats-grid" id="statsGrid">
                        <div class="loading-placeholder"><i class="fa-solid fa-spinner fa-spin"></i> 加载中...</div>
                    </div>

                    <div class="chart-row">
                        <div class="chart-box">
                            <h3>用户注册趋势（近7天）</h3>
                            <div class="chart-container" id="regTrendChart"></div>
                        </div>
                        <div class="chart-box">
                            <h3>内容分类分布</h3>
                            <div class="chart-container" id="categoryChart"></div>
                        </div>
                    </div>

                    <div class="chart-row">
                        <div class="chart-box">
                            <h3>操作日志统计（近7天）</h3>
                            <div class="chart-container" id="logStatsChart"></div>
                        </div>
                        <div class="chart-box">
                            <h3>模块操作排行</h3>
                            <div class="chart-container" id="moduleChart"></div>
                        </div>
                    </div>

                    <div class="text"><h3>快捷操作</h3></div>
                    <div class="quick-actions">
                        <a href="index.php?p=admin&c=UserAccount&a=add" class="quick-action">
                            <span class="action-icon" style="color: #409eff;"><i class="fa-solid fa-user-plus"></i></span>
                            <span class="action-label">新增用户</span>
                        </a>
                        <a href="index.php?p=admin&c=Article&f=increase" class="quick-action">
                            <span class="action-icon" style="color: #67c23a;"><i class="fa-solid fa-file-medical"></i></span>
                            <span class="action-label">新增文章</span>
                        </a>
                        <a href="index.php?p=admin&c=Image" class="quick-action">
                            <span class="action-icon" style="color: #9c27b0;"><i class="fa-solid fa-cloud-upload-alt"></i></span>
                            <span class="action-label">上传图片</span>
                        </a>
                        <a href="index.php?p=admin&c=DataIE" class="quick-action">
                            <span class="action-icon" style="color: #e6a23c;"><i class="fa-solid fa-file-export"></i></span>
                            <span class="action-label">数据导出</span>
                        </a>
                        <a href="index.php?p=admin&c=Log" class="quick-action">
                            <span class="action-icon" style="color: #f56c6c;"><i class="fa-solid fa-clipboard-list"></i></span>
                            <span class="action-label">查看日志</span>
                        </a>
                        <a href="index.php?p=admin&c=Settings" class="quick-action">
                            <span class="action-icon" style="color: #17a2b8;"><i class="fa-solid fa-gear"></i></span>
                            <span class="action-label">系统设置</span>
                        </a>
                        <a href="index.php?p=admin&c=DataBR" class="quick-action">
                            <span class="action-icon" style="color: #6c757d;"><i class="fa-solid fa-floppy-disk"></i></span>
                            <span class="action-label">备份数据</span>
                        </a>
                        <a href="index.php?p=admin&c=Cache" class="quick-action">
                            <span class="action-icon" style="color: #fd7e14;"><i class="fa-solid fa-broom"></i></span>
                            <span class="action-label">清除缓存</span>
                        </a>
                    </div>

                    <div class="recent-logs">
                        <h3>最近操作记录</h3>
                        <div id="recentLogsTable">
                            <div class="loading-placeholder"><i class="fa-solid fa-spinner fa-spin"></i> 加载中...</div>
                        </div>
                    </div>

                    <div class="text"><h3>系统状态</h3></div>
                    <div class="system-status" id="systemStatus">
                        <div class="loading-placeholder"><i class="fa-solid fa-spinner fa-spin"></i> 加载中...</div>
                    </div>


<?php echo '<script'; ?>
>
$(document).ready(function() {
    loadDashboardData();
});

function loadDashboardData() {
    $.getJSON('index.php?p=admin&c=Index&a=dashboard&_=' + Date.now(), function(res) {
        renderStatsCards(res);
        renderCharts(res);
        renderRecentLogs(res.recent_logs);
        renderSystemStatus(res);
    }).fail(function() {
        $('#statsGrid').html('<div style="text-align:center;padding:20px;color:#f56c6c;">数据加载失败，请刷新页面重试</div>');
    });
}

function renderStatsCards(data) {
    var cards = [
        { label: '总用户数', value: data.user_total, icon: 'fa-users', color: '#409eff', link: 'index.php?p=admin&c=UserAccount' },
        { label: '管理员数', value: data.user_admin, icon: 'fa-user-shield', color: '#e6a23c', link: 'index.php?p=admin&c=UserAccount' },
        { label: '内容数', value: data.content_count, icon: 'fa-file-alt', color: '#67c23a', link: 'index.php?p=admin&c=Article' },
        { label: '图片数', value: data.image_count, icon: 'fa-images', color: '#9c27b0', link: 'index.php?p=admin&c=Image' },
        { label: '视频数', value: data.video_count, icon: 'fa-video', color: '#f56c6c', link: 'index.php?p=admin&c=Video' },
        { label: '存储空间', value: data.storage_size, icon: 'fa-database', color: '#17a2b8', link: 'index.php?p=admin&c=DataIE' }
    ];
    var html = '';
    cards.forEach(function(card) {
        html += '<a href="' + card.link + '" class="stat-card" style="border-top: 3px solid ' + card.color + ';">' +
                '<div class="stat-icon" style="color: ' + card.color + ';"><i class="fa-solid ' + card.icon + '"></i></div>' +
                '<div class="stat-value" style="color: ' + card.color + ';">' + card.value + '</div>' +
                '<div class="stat-label">' + card.label + '</div></a>';
    });
    $('#statsGrid').html(html);
}

function renderCharts(data) {
    if (data.reg_trend && data.reg_trend.length > 0) {
        Highcharts.chart('regTrendChart', {
            chart: { type: 'spline' },
            title: { text: null },
            xAxis: { type: 'category', labels: { rotation: -45 } },
            yAxis: { title: { text: '新增用户' }, min: 0 },
            series: [{ name: '新增用户', data: data.reg_trend.map(function(d) { return [d.date, parseInt(d.count, 10)]; }) }]
        });
    }
    if (data.content_category && data.content_category.length > 0) {
        Highcharts.chart('categoryChart', {
            chart: { type: 'bar' },
            title: { text: null },
            xAxis: { type: 'category' },
            yAxis: { title: { text: '数量' }, min: 0 },
            series: [{ name: '数量', data: data.content_category.map(function(d) { return [d.category, parseInt(d.count, 10)]; }) }]
        });
    }
    if (data.log_stats && data.log_stats.length > 0) {
        Highcharts.chart('logStatsChart', {
            chart: { type: 'column' },
            title: { text: null },
            xAxis: { type: 'category', labels: { rotation: -45 } },
            yAxis: { title: { text: '操作次数' }, min: 0 },
            series: [{ name: '操作次数', data: data.log_stats.map(function(d) { return [d.date, parseInt(d.count, 10)]; }) }]
        });
    }
    if (data.module_stats && data.module_stats.length > 0) {
        Highcharts.chart('moduleChart', {
            chart: { type: 'pie' },
            title: { text: null },
            plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '{point.name}: {point.y}' } } },
            series: [{ name: '操作次数', data: data.module_stats.map(function(d) { return { name: d.module, y: parseInt(d.count, 10) }; }) }]
        });
    }
}

function renderRecentLogs(logs) {
    if (!logs || logs.length === 0) {
        $('#recentLogsTable').html('<div style="padding:20px;text-align:center;color:#999;">暂无操作记录</div>');
        return;
    }
    var html = '<table class="log-table"><thead><tr>' +
               '<th>时间</th><th>管理员</th><th>模块</th><th>操作</th><th>目标</th><th>状态</th>' +
               '</tr></thead><tbody>';
    logs.forEach(function(log) {
        var cls = log.status == 1 ? 'status-success' : 'status-failed';
        var txt = log.status == 1 ? '成功' : '失败';
        html += '<tr><td>' + log.created_at + '</td><td>' + log.username + '</td><td>' + log.module + '</td>' +
                '<td>' + log.action + '</td><td>' + (log.target_type || '-') + '</td>' +
                '<td class="' + cls + '">' + txt + '</td></tr>';
    });
    html += '</tbody></table>';
    $('#recentLogsTable').html(html);
}

function renderSystemStatus(data) {
    var leftItems = [
        { label: 'PHP版本', value: data.php_version },
        { label: 'MySQL版本', value: data.mysql_version },
        { label: '服务器IP', value: data.server_ip },
        { label: '当前在线用户', value: data.online_users + ' 人' }
    ];
    var rightItems = [
        { label: '数据库大小', value: data.db_size },
        { label: '缓存状态', value: data.cache_status },
        { label: '最后备份时间', value: data.last_backup },
        { label: '系统运行时间', value: data.system_uptime }
    ];
    var leftHtml = '<div class="status-box"><h3>系统信息</h3>';
    leftItems.forEach(function(item) {
        leftHtml += '<div class="status-item"><span class="status-label">' + item.label + '</span><span class="status-value">' + item.value + '</span></div>';
    });
    leftHtml += '</div>';
    var rightHtml = '<div class="status-box"><h3>运行状态</h3>';
    rightItems.forEach(function(item) {
        rightHtml += '<div class="status-item"><span class="status-label">' + item.label + '</span><span class="status-value">' + item.value + '</span></div>';
    });
    rightHtml += '</div>';
    $('#systemStatus').html(leftHtml + rightHtml);
}
<?php echo '</script'; ?>
>


                <?php } elseif ($_smarty_tpl->tpl_vars['C']->value == 'Article') {?>
                    <div class="text">
                        <h2>文章管理</h2>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Article">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <input type="hidden" name="f" value="increase">
                            <input class="input-sub" type="submit" value="新增文章"/>
                        </form>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Article">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <input type="hidden" name="f" value="change">
                            <input class="input-sub" type="submit" value="编辑文章"/>
                        </form>
                    </div>
                    <div class="article">
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Article">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['TablesName']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                <input class="input-sub" type="submit" name="tableName" value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
">
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </form>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['tableData']->value != '') {?>
                        <table class="layui-table">
                            <?php $_smarty_tpl->_assignInScope('i', 0);?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tableData']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
                                    <tr>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
                                            <?php if ($_smarty_tpl->tpl_vars['key']->value != 'content') {?>
                                                <th><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</th>
                                            <?php }?>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tr>
                                    <?php $_smarty_tpl->_assignInScope('i', 1);?>
                                <?php }?>
                                <tr>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
                                        <?php if ($_smarty_tpl->tpl_vars['key']->value != 'content') {?>
                                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</td>
                                        <?php }?>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </tr>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </table>
                    <?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['C']->value == 'Image') {?>
                    <div class="text">
                        <h2>图片管理</h2>
                        <form action="/" method="post" style="display:inline; margin-right:10px;" enctype="multipart/form-data">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Image">
                            <input type="hidden" name="a" value="upload">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <input type="file" name="file" required style="display:inline; width:auto; font-size:13px;">
                            <input class="input-sub" type="submit" value="上传">
                        </form>
                    </div>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['filedata']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                    <div class="image">
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == 'folder') {?>
                            <form action="/" method="post">
                                <input type="hidden" name="p" value="admin">
                                <input type="hidden" name="c" value="Image">
                                <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                <input type="hidden" name="path" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['currentPath'];?>
">
                                <a href="/"  onclick="this.parentNode.submit(); return false;">
                                    <i class="fa-regular fa-folder"></i>
                                    <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

                                </a>
                            </form>
                        <?php } else { ?>
                            <form action="/" method="post">
                                <input type="hidden" name="p" value="admin">
                                <input type="hidden" name="c" value="Image">
                                <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['extension'] == 'jpg' || $_smarty_tpl->tpl_vars['item']->value['extension'] == 'png' || $_smarty_tpl->tpl_vars['item']->value['extension'] == 'gif' || $_smarty_tpl->tpl_vars['item']->value['extension'] == 'jpeg' || $_smarty_tpl->tpl_vars['item']->value['extension'] == 'webp' || $_smarty_tpl->tpl_vars['item']->value['extension'] == 'ico') {?>
                                    <a href="/"  onclick="this.parentNode.submit(); return false;">
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['parentPath'] == '/home/sky/www/public/images') {?>
                                            <img src="/images/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" width="60" height="50"/>
                                        <?php } else { ?>
                                            <img src="/images/<?php echo $_smarty_tpl->tpl_vars['typePath']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" width="60" height="50"/>
                                        <?php }?>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

                                    </a>
                                <?php } else { ?>
                                    <a href="/"  onclick="this.parentNode.submit(); return false;">
                                        <i class="fa-regular fa-file"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

                                    </a>
                                <?php }?>
                            </form>
                            <form action="/" method="post" style="margin-top:4px;">
                                <input type="hidden" name="p" value="admin">
                                <input type="hidden" name="c" value="Image">
                                <input type="hidden" name="a" value="delete">
                                <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                <input type="hidden" name="filePath" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['currentPath'];?>
">
                                <button type="submit" style="color:#f56c6c; background:none; border:none; cursor:pointer; font-size:12px;" onclick="return confirm('确定要删除 <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
 吗？')">删除</button>
                            </form>
                        <?php }?>
                        <div class="tips">
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == 'folder') {?>
                                <p>创建时间：<?php echo $_smarty_tpl->tpl_vars['item']->value['CreationTime'];?>
</p>
                                大小：<?php echo $_smarty_tpl->tpl_vars['item']->value['fileSize'];?>
 <br/>
                            <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<br/>
                                类型：<?php echo $_smarty_tpl->tpl_vars['item']->value['extension'];?>
文件 <br/>
                                大小：<?php echo $_smarty_tpl->tpl_vars['item']->value['fileSize'];?>
 <br/>
                                创建时间：<?php echo $_smarty_tpl->tpl_vars['item']->value['CreationTime'];?>
 <br/>
                            <?php }?>
                        </div>
                    </div>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } elseif ($_smarty_tpl->tpl_vars['C']->value == 'Data') {?>
                    <div>
                        <form action="/" method="post">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            表名：
                            <select class="input-select" name="tableName">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['TablesName']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value == $_smarty_tpl->tpl_vars['tableName']->value) {?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" selected><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                    <?php } else { ?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                    <?php }?>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                            <input class="input-sub" type="submit" value="查询">
                        </form>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['tableName']->value != '') {?>
                        <table class="layui-table">
                            <?php $_smarty_tpl->_assignInScope('i', 0);?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tableData']->value['data'], 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
                                    <tr>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
                                            <?php if ($_smarty_tpl->tpl_vars['key']->value != 'content') {?>
                                                <th><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</th>
                                            <?php }?>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tr>
                                    <?php $_smarty_tpl->_assignInScope('i', 1);?>
                                <?php }?>
                                <tr>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
                                        <?php if ($_smarty_tpl->tpl_vars['key']->value != 'content') {?>
                                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</td>
                                        <?php }?>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </tr>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </table>

                        <?php if ($_smarty_tpl->tpl_vars['tableData']->value['total'] > 17) {?>
                            <div class="kg-pager">
                                <div class="layui-box layui-laypage ">
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="admin">
                                        <input type="hidden" name="c" value="Data">
                                        <input type="hidden" name="tableName" value="<?php echo $_smarty_tpl->tpl_vars['tableName']->value;?>
">
                                        <input type="hidden" name="page" value="1">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">首页</a>
                                    </form>
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="admin">
                                        <input type="hidden" name="c" value="Data">
                                        <input type="hidden" name="tableName" value="<?php echo $_smarty_tpl->tpl_vars['tableName']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['tableData']->value['prevPage'];?>
">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">上页</a>
                                    </form>
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="admin">
                                        <input type="hidden" name="c" value="Data">
                                        <input type="hidden" name="tableName" value="<?php echo $_smarty_tpl->tpl_vars['tableName']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['tableData']->value['nextPage'];?>
">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">下页</a>
                                    </form>
                                    <form action="/" method="post">
                                        <input type="hidden" name="p" value="admin">
                                        <input type="hidden" name="c" value="Data">
                                        <input type="hidden" name="tableName" value="<?php echo $_smarty_tpl->tpl_vars['tableName']->value;?>
">
                                        <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['tableData']->value['totalPages'];?>
">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                        <a href="/"  onclick="this.parentNode.submit(); return false;">尾页</a>
                                    </form>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['C']->value == 'Video') {?>
                    <div class="text">
                        <h2>视频管理</h2>
                        <form action="/" method="post" style="display:inline;" enctype="multipart/form-data">
                            <input type="hidden" name="p" value="admin">
                            <input type="hidden" name="c" value="Video">
                            <input type="hidden" name="a" value="upload">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <input type="file" name="file" accept="video/*" required style="display:inline; width:auto; font-size:13px;">
                            <input class="input-sub" type="submit" value="上传">
                        </form>
                    </div>
                    <?php if (count($_smarty_tpl->tpl_vars['videos']->value) == 0) {?>
                        <p style="color:#999; padding:20px;">暂无视频</p>
                    <?php } else { ?>
                        <table class="user-table">
                            <tr>
                                <th>文件名</th>
                                <th>大小</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['videos']->value, 'video');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['video']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['video']->value['name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['video']->value['size'];?>
</td>
                                <td style="font-size:12px;"><?php echo $_smarty_tpl->tpl_vars['video']->value['mtime'];?>
</td>
                                <td>
                                    <form action="/" method="post" style="display:inline;">
                                        <input type="hidden" name="p" value="admin">
                                        <input type="hidden" name="c" value="Video">
                                        <input type="hidden" name="a" value="delete">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                        <input type="hidden" name="filePath" value="<?php echo $_smarty_tpl->tpl_vars['video']->value['path'];?>
">
                                        <button type="submit" style="color:#f56c6c; background:none; border:none; cursor:pointer;" onclick="return confirm('确定要删除 <?php echo $_smarty_tpl->tpl_vars['video']->value['name'];?>
 吗？')">删除</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </table>
                    <?php }?>
                <?php }?>

            </article>
        </div>
    </div>
</body>
</html><?php }
}
