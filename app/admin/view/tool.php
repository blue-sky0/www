<!DOCTYPE html>
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
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
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
            <div class="text"><h2>优化工具</h2></div>

            {if $smarty.session.success_msg neq ''}
                <div class="msg-success">{$smarty.session.success_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 4000);</script>
                {$_SESSION['success_msg'] = ''}
            {/if}
            {if $smarty.session.error_msg neq ''}
                <div class="msg-error">{$smarty.session.error_msg}</div>
                <script>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 4000);</script>
                {$_SESSION['error_msg'] = ''}
            {/if}

            <div class="action-bar">
                <form action="/" method="post" style="display:inline;" onsubmit="return confirm('确定优化所有数据表？')">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Tool">
                    <input type="hidden" name="a" value="optimize">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <button type="submit" class="btn btn-success">优化所有数据表</button>
                </form>
                <form action="/" method="post" style="display:inline;">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Tool">
                    <input type="hidden" name="a" value="clearPhpCache">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <button type="submit" class="btn btn-primary">重置 OPCache</button>
                </form>
            </div>

            <div class="stats-grid">
                <div class="stat-card" style="padding:10px;">
                    <div class="score-meter grade-{$scoreInfo.grade}">{$scoreInfo.score}</div>
                    <div class="stat-label">性能评分</div>
                    <div class="stat-sub" style="font-size:11px;color:#999;">等级 {$scoreInfo.grade}</div>
                </div>
                <div class="stat-card stat-blue"><div class="stat-value">{$system.cpu.load_pct|default:'N/A'}{if $system.cpu.load_pct}%{/if}</div><div class="stat-label">CPU 使用率</div><div class="stat-sub">1min: {$system.cpu.1min|default:'-'} | 核心: {$system.cpu.cores|default:'-'}</div></div>
                <div class="stat-card stat-green"><div class="stat-value">{$system.memory.usage_pct|default:'N/A'}{if $system.memory.usage_pct}%{/if}</div><div class="stat-label">内存使用率</div><div class="stat-sub">{$system.memory.used_mb|default:'?'}/{$system.memory.total_mb|default:'?'} MB</div></div>
                <div class="stat-card stat-orange"><div class="stat-value">{$system.disk.usage_pct|default:'N/A'}{if $system.disk.usage_pct}%{/if}</div><div class="stat-label">磁盘使用率</div><div class="stat-sub">{$system.disk.used_gb|default:'?'}/{$system.disk.total_gb|default:'?'} GB</div></div>
            </div>

            <div class="half-grid">
                <div class="chart-box">
                    <h3>页面响应时间趋势 (近7天)</h3>
                    <div id="responseChart" class="chart-container"></div>
                </div>
                <div class="card">
                    <h3>优化建议</h3>
                    {foreach $optimizationTips as $tip}
                    <div class="issue-item issue-{$tip.severity}">
                        <strong>{$tip.title}</strong><br>
                        <span style="color:#666;">{$tip.desc}</span>
                        {if $tip.fix}<br><small style="color:#409eff;">{$tip.fix}</small>{/if}
                    </div>
                    {foreachelse}
                    <p style="color:#999;text-align:center;padding:20px;">暂无优化建议</p>
                    {/foreach}
                </div>
            </div>

            <div class="half-grid">
                <div class="card">
                    <h3>PHP 配置</h3>
                    <table class="info-table">
                        <tr><th>版本</th><td>{$system.php.version}</td></tr>
                        <tr><th>内存限制</th><td>{$system.php.memory_limit}</td></tr>
                        <tr><th>执行时间</th><td>{$system.php.max_exec_time}</td></tr>
                        <tr><th>上传限制</th><td>{$system.php.upload_max}</td></tr>
                        <tr><th>OPCache</th><td>{$system.php.opcache}</td></tr>
                        <tr><th>服务器</th><td>{$system.server.name}</td></tr>
                        <tr><th>系统</th><td>{$system.server.os}</td></tr>
                        <tr><th>运行时间</th><td>{$system.server.uptime|default:'-'}</td></tr>
                    </table>
                </div>
                <div class="card">
                    <h3>数据库状态</h3>
                    <table class="info-table">
                        <tr><th>总查询数</th><td>{$dbStatus.queries_total|default:'-'}</td></tr>
                        <tr><th>慢查询</th><td><span style="color:{if $dbStatus.slow_queries gt 100}#f56c6c{else}#67c23a{/if};">{$dbStatus.slow_queries|default:0}</span></td></tr>
                        <tr><th>活跃连接</th><td>{$dbStatus.active_connections|default:0}</td></tr>
                        <tr><th>长运行查询</th><td>{if $dbStatus.long_running gt 0}<span style="color:#f56c6c;">{$dbStatus.long_running}</span>{else}0{/if}</td></tr>
                        <tr><th>数据库大小</th><td>{$dbStatus.db_size_mb|default:0} MB</td></tr>
                        <tr><th>表数量</th><td>{$dbStatus.table_count|default:0}</td></tr>
                        <tr><th>慢查询日志</th><td>{$dbStatus.slow_query_log|default:'N/A'}</td></tr>
                    </table>
                </div>
            </div>

            {if $slowQueries|@count gt 0}
            <div class="card">
                <h3>慢查询 (运行 &gt; 2s)</h3>
                <div class="scroll-box">
                    <table class="info-table" style="font-size:12px;">
                        <tr><th>时间</th><th>用户</th><th>SQL</th></tr>
                        {foreach $slowQueries as $q}
                        <tr>
                            <td><small>{$q.Time}s</small></td>
                            <td><small>{$q.User|default:'-'}</small></td>
                            <td style="max-width:400px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{$q.Info|default:''|escape:'html'}"><small>{$q.Info|default:''|truncate:60}</small></td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
            </div>
            {/if}

            {if is_array($errors) && $errors.error|default:'' eq ''}
            <div class="card">
                <h3>最近 PHP 错误</h3>
                <div class="error-log-box">
                    {foreach $errors as $line}
                    <div>{$line|escape:'html'}</div>
                    {foreachelse}
                    <div style="color:#67c23a;">无错误日志</div>
                    {/foreach}
                </div>
            </div>
            {/if}

            <div class="card">
                <h3>数据表状态</h3>
                <div class="scroll-box">
                    <table class="info-table" style="font-size:12px;">
                        <tr><th>表名</th><th>引擎</th><th>行数</th><th>数据</th><th>索引</th><th>总大小</th><th>整理碎片</th></tr>
                        {foreach $tables as $t}
                        <tr>
                            <td style="font-family:monospace;">{$t.name}</td>
                            <td><small>{$t.engine}</small></td>
                            <td><small>{$t.rows}</small></td>
                            <td><small>{$t.data_size}</small></td>
                            <td><small>{$t.index_size}</small></td>
                            <td><small>{$t.total_size}</small></td>
                            <td><small>{$t.overhead}</small></td>
                        </tr>
                        {foreachelse}
                        <tr><td colspan="7" style="text-align:center;color:#999;padding:20px;">{$tables.error|default:'暂无数据'}</td></tr>
                        {/foreach}
                    </table>
                </div>
            </div>
        </article>
    </div>
</div>
{literal}
<script>
var responseChart = echarts.init(document.getElementById('responseChart'));
responseChart.setOption({
    tooltip: { trigger: 'axis' },
    legend: { data: ['平均响应', '最大响应'] },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: { type: 'category', data: {/literal}{$rtLabels}{literal} },
    yAxis: { type: 'value', name: 'ms' },
    series: [
        { name: '平均响应', type: 'line', smooth: true, data: {/literal}{$rtAvg}{literal}, color: '#409eff', areaStyle: { color: 'rgba(64,158,255,0.1)' } },
        { name: '最大响应', type: 'line', smooth: true, data: {/literal}{$rtMax}{literal}, color: '#f56c6c', lineStyle: { type: 'dashed' } }
    ]
});
window.addEventListener('resize', function(){ responseChart.resize(); });
</script>
{/literal}
</body>
</html>
