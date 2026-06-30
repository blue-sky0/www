<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>行为分析 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 26px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .stat-blue .stat-value { color: #409eff; }
        .stat-green .stat-value { color: #67c23a; }
        .stat-orange .stat-value { color: #e6a23c; }
        .chart-box { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-bottom: 20px; }
        .chart-box h3 { margin: 0 0 10px 0; font-size: 15px; }
        .chart-container { width: 100%; height: 350px; }
        .half-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .page-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .page-table th, .page-table td { padding: 6px 10px; border: 1px solid #e6e6e6; text-align: left; }
        .page-table th { background: #f2f2f2; }
        .page-table tr:hover { background: #f5f7fa; }
        .referrer-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .referrer-table th, .referrer-table td { padding: 6px 10px; border: 1px solid #e6e6e6; text-align: left; }
        .referrer-table th { background: #f2f2f2; }
        .scroll-box { max-height: 300px; overflow-y: auto; }
        .text-right { text-align: right; }
        .btn-link { display: inline-block; padding: 6px 15px; background: #409eff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-link:hover { background: #337ecc; }
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
            <div class="text">
                <h2>行为分析</h2>
                <a href="index.php?p=admin&c=BehaviorAnalysis&a=list" style="font-size:13px;color:#409eff;margin-left:10px;">访问日志 &raquo;</a>
            </div>

            <div class="stats-grid">
                <div class="stat-card stat-blue"><div class="stat-value">{$realtime.last_5min}</div><div class="stat-label">5分钟内活跃</div></div>
                <div class="stat-card stat-green"><div class="stat-value">{$realtime.last_1hour}</div><div class="stat-label">1小时内活跃</div></div>
                <div class="stat-card stat-orange"><div class="stat-value">{$realtime.last_24hour}</div><div class="stat-label">24小时内活跃</div></div>
            </div>

            <div class="chart-box">
                <h3>近7日访问趋势</h3>
                <div id="trendChart" class="chart-container"></div>
            </div>

            <div class="half-grid">
                <div class="chart-box">
                    <h3>热门页面 (TOP 15)</h3>
                    <div class="scroll-box">
                        <table class="page-table">
                            <tr><th>页面</th><th>PV</th><th>UV</th><th class="text-right">平均响应(ms)</th></tr>
                            {foreach $topPages as $p}
                            <tr>
                                <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{$p.page_title|default:''}">{$p.request_url}</td>
                                <td>{$p.pv}</td>
                                <td>{$p.uv}</td>
                                <td class="text-right">{$p.avg_time|intval}</td>
                            </tr>
                            {foreachelse}
                            <tr><td colspan="4" style="text-align:center;color:#999;padding:20px;">暂无数据</td></tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
                <div class="chart-box">
                    <h3>来源网站 (TOP 10)</h3>
                    <div class="scroll-box">
                        <table class="referrer-table">
                            <tr><th>来源</th><th>访问次数</th></tr>
                            {foreach $referrers as $r}
                            <tr>
                                <td style="max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{$r.referer_url}">{$r.referer_url}</td>
                                <td>{$r.count}</td>
                            </tr>
                            {foreachelse}
                            <tr><td colspan="2" style="text-align:center;color:#999;padding:20px;">暂无数据</td></tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
{literal}
<script>
var trendChart = echarts.init(document.getElementById('trendChart'));
var option = {
    tooltip: { trigger: 'axis' },
    legend: { data: ['PV', 'UV'] },
    xAxis: { type: 'category', data: {/literal}{$trendLabels}{literal} },
    yAxis: { type: 'value', min: 0 },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    series: [
        {
            name: 'PV',
            type: 'line',
            smooth: true,
            data: {/literal}{$trendPv}{literal},
            itemStyle: { color: '#409eff' },
            areaStyle: { color: 'rgba(64,158,255,0.1)' }
        },
        {
            name: 'UV',
            type: 'line',
            smooth: true,
            data: {/literal}{$trendUv}{literal},
            itemStyle: { color: '#67c23a' },
            areaStyle: { color: 'rgba(103,194,58,0.1)' }
        }
    ]
};
trendChart.setOption(option);
window.addEventListener('resize', function(){ trendChart.resize(); });
</script>
{/literal}
</body>
</html>
