<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户访问路径 - 后台管理系统</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/base.css">
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <style>
        .timeline { position: relative; padding-left: 30px; margin: 20px 0; }
        .timeline::before { content: ''; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: #dcdfe6; }
        .timeline-item { position: relative; margin-bottom: 15px; padding: 10px 15px; background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; }
        .timeline-item::before { content: ''; position: absolute; left: -24px; top: 14px; width: 10px; height: 10px; border-radius: 50%; background: #409eff; border: 2px solid #fff; box-shadow: 0 0 0 2px #409eff; }
        .timeline-time { font-size: 12px; color: #999; }
        .timeline-url { font-size: 13px; margin: 4px 0; word-break: break-all; }
        .timeline-title { font-size: 12px; color: #666; }
        .timeline-meta { font-size: 11px; color: #999; margin-top: 4px; }
        .tag { display: inline-block; padding: 1px 4px; border-radius: 2px; font-size: 10px; }
        .tag-admin { background: #fef0f0; color: #f56c6c; border: 1px solid #fde2e2; }
        .tag-user { background: #f0f9eb; color: #67c23a; border: 1px solid #e1f3d8; }
        .tag-guest { background: #f4f4f5; color: #909399; border: 1px solid #e9e9eb; }
        .btn-back { display: inline-block; padding: 6px 15px; background: #409eff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
        .btn-back:hover { background: #337ecc; }
        .arrow { text-align: center; color: #dcdfe6; font-size: 20px; margin: -5px 0 5px 0; }
    </style>
</head>
<body>
<div id="container">
    <div style="padding:20px;">
        <a href="index.php?p=admin&c=BehaviorAnalysis&a=list" class="btn-back">&laquo; 返回访问日志</a>
        <h2>用户访问路径</h2>
        <p style="font-size:13px;color:#999;margin:5px 0 15px 0;">Session: <code style="font-family:monospace;">{$sessionId}</code></p>

        {if $journey|@count gt 0}
            <div class="timeline">
                {foreach $journey as $j}
                    <div class="timeline-item">
                        <div class="timeline-time">{$j.created_at}</div>
                        <div class="timeline-url">
                            {if $j.user_type eq 'admin'}<span class="tag tag-admin">管理员</span>
                            {elseif $j.user_type eq 'user'}<span class="tag tag-user">用户</span>
                            {else}<span class="tag tag-guest">游客</span>
                            {/if}
                            <strong>{$j.request_method}</strong> {$j.request_url}
                        </div>
                        {if $j.page_title}
                            <div class="timeline-title">{$j.page_title}</div>
                        {/if}
                        <div class="timeline-meta">
                            IP: {$j.ip_address} | 耗时: {if $j.response_time}{$j.response_time}ms{else}-{/if} | 状态: {$j.response_code}
                            {if $j.referer_url}<br>来源: {$j.referer_url}{/if}
                        </div>
                    </div>
                {/foreach}
            </div>
        {else}
            <div style="text-align:center;padding:40px;color:#999;border:1px solid #e6e6e6;border-radius:6px;background:#fafafa;">
                暂无访问路径记录
            </div>
        {/if}
    </div>
</div>
</body>
</html>
