<!DOCTYPE html>
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
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
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
            <div class="text"><h2>数据报表</h2></div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{$userStats.total_users}</div>
                    <div class="stat-label">总用户数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{$userStats.admin_users}</div>
                    <div class="stat-label">管理员</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{$contentCount}</div>
                    <div class="stat-label">内容数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{$imageCount}</div>
                    <div class="stat-label">图片数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{$videoCount}</div>
                    <div class="stat-label">视频数</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="font-size:20px;">{$storageSize}</div>
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

            <script>
                {literal}
                var regData = {/literal}{$regTrendJson}{literal};
                var catData = {/literal}{$categoryStatsJson}{literal};
                var logData = {/literal}{$logStatsJson}{literal};
                var modData = {/literal}{$moduleStatsJson}{literal};
                var contentData = {/literal}{$dailyContentJson}{literal};

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
                {/literal}
            </script>

        </article>
    </div>
</div>
</body>
</html>
