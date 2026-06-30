<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安全审计 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 15px; text-align: center; }
        .stat-card .stat-value { font-size: 26px; font-weight: bold; }
        .stat-card .stat-label { font-size: 12px; color: #999; margin-top: 4px; }
        .score-big { font-size: 3rem; font-weight: 700; }
        .grade-A { color: #67c23a; } .grade-B { color: #409eff; }
        .grade-C { color: #e6a23c; } .grade-D { color: #f56c6c; }
        .severity-dot { display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 4px; }
        .dot-critical { background: #f56c6c; } .dot-high { background: #e6a23c; }
        .dot-medium { background: #409eff; } .dot-low { background: #909399; } .dot-info { background: #c0c4cc; }
        .audit-table { width: 100%; border-collapse: collapse; }
        .audit-table th, .audit-table td { padding: 8px 10px; border: 1px solid #e6e6e6; text-align: left; font-size: 13px; }
        .audit-table th { background: #f2f2f2; font-weight: bold; white-space: nowrap; }
        .audit-table tr:hover { background: #f5f7fa; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 11px; }
        .badge-critical { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .badge-high { background: #fdf6ec; color: #e6a23c; border: 1px solid #faecd8; }
        .badge-medium { background: #ecf5ff; color: #409eff; border: 1px solid #d9ecff; }
        .badge-low { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .badge-info { background: #fafafa; color: #c0c4cc; border: 1px solid #eee; }
        .summary-box { padding: 15px; border-radius: 6px; margin-top: 15px; font-size: 14px; }
        .summary-good { background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; }
        .summary-warn { background: #fdf6ec; border: 1px solid #faecd8; color: #e6a23c; }
        .summary-bad { background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; }
        .filter-bar { margin-bottom: 15px; display: flex; gap: 8px; align-items: center; }
        .filter-bar select { padding: 5px 8px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 13px; }
        .severity-box { padding: 15px; text-align: center; border-radius: 6px; color: #fff; }
        .bg-critical { background: #f56c6c; } .bg-high { background: #e6a23c; }
        .bg-medium { background: #409eff; } .bg-low { background: #909399; }
        .refresh-btn { display: inline-block; padding: 6px 15px; background: #409eff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; border: none; cursor: pointer; }
        .refresh-btn:hover { background: #337ecc; }
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
            <div class="text"><h2>安全审计报告</h2></div>

            {if !empty($report)}
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                <span style="font-size:13px;color:#999;">生成时间: {$report.report_time}</span>
                <a href="index.php?p=admin&c=Security" class="refresh-btn">重新扫描</a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="score-big grade-{$report.grade|substr:0:1}">{$report.score}</div>
                    <div class="stat-label">安全评分</div>
                    <div style="font-size:12px;color:#999;">{$report.grade}</div>
                </div>
                <div class="stat-card"><div class="stat-value" style="color:#f56c6c;">{$report.severity_counts.critical|default:0}</div><div class="stat-label">紧急</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#e6a23c;">{$report.severity_counts.high|default:0}</div><div class="stat-label">高危</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#409eff;">{$report.severity_counts.medium|default:0}</div><div class="stat-label">中危</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#909399;">{$report.severity_counts.low|default:0}</div><div class="stat-label">低危</div></div>
            </div>

            <div class="filter-bar">
                <label style="font-size:13px;color:#666;">筛选严重程度：</label>
                <select id="severityFilter" onchange="filterIssues()">
                    <option value="all">全部 ({$report.total_issues})</option>
                    <option value="critical">紧急 ({$report.severity_counts.critical|default:0})</option>
                    <option value="high">高危 ({$report.severity_counts.high|default:0})</option>
                    <option value="medium">中危 ({$report.severity_counts.medium|default:0})</option>
                    <option value="low">低危 ({$report.severity_counts.low|default:0})</option>
                    <option value="info">提示 ({$report.severity_counts.info|default:0})</option>
                </select>
            </div>

            <table class="audit-table" id="issueTable">
                <tr>
                    <th style="width:80px;">严重程度</th>
                    <th style="width:100px;">类别</th>
                    <th>描述</th>
                    <th>修复建议</th>
                </tr>
                {foreach $report.results as $issue}
                <tr class="issue-row" data-severity="{$issue.severity}">
                    <td>
                        <span class="severity-dot dot-{$issue.severity}"></span>
                        <span class="badge badge-{$issue.severity}">
                            {if $issue.severity eq 'critical'}紧急
                            {elseif $issue.severity eq 'high'}高危
                            {elseif $issue.severity eq 'medium'}中危
                            {elseif $issue.severity eq 'low'}低危
                            {else}提示{/if}
                        </span>
                    </td>
                    <td><small>{$issue.category}<br><code style="font-size:10px;">{$issue.id}</code></small></td>
                    <td>{$issue.description}</td>
                    <td><small><code>{$issue.suggestion}</code></small></td>
                </tr>
                {/foreach}
            </table>

            <div class="summary-box 
                {if $report.score gte 75}summary-good
                {elseif $report.score gte 50}summary-warn
                {else}summary-bad{/if}">
                <strong>审计摘要：</strong>{$report.summary}
            </div>

            {else}
            <div style="text-align:center;padding:40px;color:#999;border:1px solid #e6e6e6;border-radius:6px;background:#fafafa;">
                加载审计报告失败，请重试
            </div>
            {/if}
        </article>
    </div>
</div>
<script>
function filterIssues() {
    var val = document.getElementById('severityFilter').value;
    var rows = document.querySelectorAll('.issue-row');
    for (var i = 0; i < rows.length; i++) {
        if (val === 'all' || rows[i].dataset.severity === val) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}
</script>
</body>
</html>
