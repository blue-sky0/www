<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:56:29
  from '/home/sky/www/app/admin/view/datareport.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced3da6f051_05122574',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ebb2d991bc345a77b1fb5c10d01ea6555061fde7' => 
    array (
      0 => '/home/sky/www/app/admin/view/datareport.php',
      1 => 1782377778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced3da6f051_05122574 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据报表 - 后台管理系统</title>
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
 type="text/javascript" src="js/highcharts.js"><?php echo '</script'; ?>
>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; text-align: center; }
        .stat-card .stat-value { font-size: 28px; font-weight: bold; color: #409eff; }
        .stat-card .stat-label { font-size: 13px; color: #999; margin-top: 5px; }
        .chart-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        @media (max-width: 900px) { .chart-row { grid-template-columns: 1fr; } }
        .chart-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; }
        .chart-box h3 { margin: 0 0 10px 0; font-size: 15px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 8px; }
        .chart-box .chart-container { height: 300px; }
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
            <div class="text"><h2>数据报表</h2></div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['userStats']->value['total_users'];?>
</div>
                    <div class="stat-label">总用户数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['userStats']->value['admin_users'];?>
</div>
                    <div class="stat-label">管理员</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['contentCount']->value;?>
</div>
                    <div class="stat-label">内容数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['imageCount']->value;?>
</div>
                    <div class="stat-label">图片数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $_smarty_tpl->tpl_vars['videoCount']->value;?>
</div>
                    <div class="stat-label">视频数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="font-size:20px;"><?php echo $_smarty_tpl->tpl_vars['storageSize']->value;?>
</div>
                    <div class="stat-label">存储空间</div>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-box">
                    <h3>近期注册趋势</h3>
                    <div class="chart-container" id="regChart"></div>
                </div>
                <div class="chart-box">
                    <h3>文章分类统计</h3>
                    <div class="chart-container" id="categoryChart"></div>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-box">
                    <h3>近期操作日志</h3>
                    <div class="chart-container" id="logChart"></div>
                </div>
                <div class="chart-box">
                    <h3>模块操作统计</h3>
                    <div class="chart-container" id="moduleChart"></div>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-box">
                    <h3>每日内容发布</h3>
                    <div class="chart-container" id="contentChart"></div>
                </div>
            </div>

            <?php echo '<script'; ?>
>
                
                var regData = <?php echo $_smarty_tpl->tpl_vars['regTrendJson']->value;?>
;
                var catData = <?php echo $_smarty_tpl->tpl_vars['categoryStatsJson']->value;?>
;
                var logData = <?php echo $_smarty_tpl->tpl_vars['logStatsJson']->value;?>
;
                var modData = <?php echo $_smarty_tpl->tpl_vars['moduleStatsJson']->value;?>
;
                var contentData = <?php echo $_smarty_tpl->tpl_vars['dailyContentJson']->value;?>
;

                function makeSeries(data) {
                    return data.map(function(d) {
                        var keys = Object.keys(d);
                        return [d[keys[0]], parseInt(d[keys[1]], 10)];
                    });
                }

                function makePieData(data) {
                    return data.map(function(d) {
                        var keys = Object.keys(d);
                        return { name: d[keys[0]], y: parseInt(d[keys[1]], 10) };
                    });
                }

                if (regData.length > 0) {
                    Highcharts.chart('regChart', {
                        chart: { type: 'spline' },
                        title: { text: null },
                        xAxis: { type: 'category', labels: { rotation: -45 } },
                        yAxis: { title: { text: '注册数' }, min: 0 },
                        series: [{ name: '用户注册', data: makeSeries(regData) }]
                    });
                }

                if (catData.length > 0) {
                    Highcharts.chart('categoryChart', {
                        chart: { type: 'bar' },
                        title: { text: null },
                        xAxis: { type: 'category' },
                        yAxis: { title: { text: '数量' }, min: 0 },
                        series: [{ name: '数量', data: makeSeries(catData) }]
                    });
                }

                if (logData.length > 0) {
                    Highcharts.chart('logChart', {
                        chart: { type: 'column' },
                        title: { text: null },
                        xAxis: { type: 'category', labels: { rotation: -45 } },
                        yAxis: { title: { text: '操作次数' }, min: 0 },
                        series: [{ name: '操作日志', data: makeSeries(logData) }]
                    });
                }

                if (modData.length > 0) {
                    Highcharts.chart('moduleChart', {
                        chart: { type: 'pie' },
                        title: { text: null },
                        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '{point.name}: {point.y}' } } },
                        series: [{ name: '操作', data: makePieData(modData) }]
                    });
                }

                if (contentData.length > 0) {
                    Highcharts.chart('contentChart', {
                        chart: { type: 'areaspline' },
                        title: { text: null },
                        xAxis: { type: 'category', labels: { rotation: -45 } },
                        yAxis: { title: { text: '数量' }, min: 0 },
                        series: [{ name: '新增', data: makeSeries(contentData) }]
                    });
                }
                
            <?php echo '</script'; ?>
>

        </article>
    </div>
</div>
</body>
</html>
<?php }
}
