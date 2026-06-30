<?php
/* Smarty version 3.1.32, created on 2026-06-25 09:19:09
  from '/home/sky/www/app/admin/view/security.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3cf28d4005b6_79102359',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '190ba2bf28ef23ad541436b538424f6fbcf70b42' => 
    array (
      0 => '/home/sky/www/app/admin/view/security.php',
      1 => 1782377771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3cf28d4005b6_79102359 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.7.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/admin.js"><?php echo '</script'; ?>
>
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
            <div class="text"><h2>安全审计报告</h2></div>

            <?php if (!empty($_smarty_tpl->tpl_vars['report']->value)) {?>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                <span style="font-size:13px;color:#999;">生成时间: <?php echo $_smarty_tpl->tpl_vars['report']->value['report_time'];?>
</span>
                <a href="index.php?p=admin&c=Security" class="refresh-btn">重新扫描</a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="score-big grade-<?php echo substr($_smarty_tpl->tpl_vars['report']->value['grade'],0,1);?>
"><?php echo $_smarty_tpl->tpl_vars['report']->value['score'];?>
</div>
                    <div class="stat-label">安全评分</div>
                    <div style="font-size:12px;color:#999;"><?php echo $_smarty_tpl->tpl_vars['report']->value['grade'];?>
</div>
                </div>
                <div class="stat-card"><div class="stat-value" style="color:#f56c6c;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['critical'])===null||$tmp==='' ? 0 : $tmp);?>
</div><div class="stat-label">紧急</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#e6a23c;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['high'])===null||$tmp==='' ? 0 : $tmp);?>
</div><div class="stat-label">高危</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#409eff;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['medium'])===null||$tmp==='' ? 0 : $tmp);?>
</div><div class="stat-label">中危</div></div>
                <div class="stat-card"><div class="stat-value" style="color:#909399;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['low'])===null||$tmp==='' ? 0 : $tmp);?>
</div><div class="stat-label">低危</div></div>
            </div>

            <div class="filter-bar">
                <label style="font-size:13px;color:#666;">筛选严重程度：</label>
                <select id="severityFilter" onchange="filterIssues()">
                    <option value="all">全部 (<?php echo $_smarty_tpl->tpl_vars['report']->value['total_issues'];?>
)</option>
                    <option value="critical">紧急 (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['critical'])===null||$tmp==='' ? 0 : $tmp);?>
)</option>
                    <option value="high">高危 (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['high'])===null||$tmp==='' ? 0 : $tmp);?>
)</option>
                    <option value="medium">中危 (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['medium'])===null||$tmp==='' ? 0 : $tmp);?>
)</option>
                    <option value="low">低危 (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['low'])===null||$tmp==='' ? 0 : $tmp);?>
)</option>
                    <option value="info">提示 (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['report']->value['severity_counts']['info'])===null||$tmp==='' ? 0 : $tmp);?>
)</option>
                </select>
            </div>

            <table class="audit-table" id="issueTable">
                <tr>
                    <th style="width:80px;">严重程度</th>
                    <th style="width:100px;">类别</th>
                    <th>描述</th>
                    <th>修复建议</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['report']->value['results'], 'issue');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['issue']->value) {
?>
                <tr class="issue-row" data-severity="<?php echo $_smarty_tpl->tpl_vars['issue']->value['severity'];?>
">
                    <td>
                        <span class="severity-dot dot-<?php echo $_smarty_tpl->tpl_vars['issue']->value['severity'];?>
"></span>
                        <span class="badge badge-<?php echo $_smarty_tpl->tpl_vars['issue']->value['severity'];?>
">
                            <?php if ($_smarty_tpl->tpl_vars['issue']->value['severity'] == 'critical') {?>紧急
                            <?php } elseif ($_smarty_tpl->tpl_vars['issue']->value['severity'] == 'high') {?>高危
                            <?php } elseif ($_smarty_tpl->tpl_vars['issue']->value['severity'] == 'medium') {?>中危
                            <?php } elseif ($_smarty_tpl->tpl_vars['issue']->value['severity'] == 'low') {?>低危
                            <?php } else { ?>提示<?php }?>
                        </span>
                    </td>
                    <td><small><?php echo $_smarty_tpl->tpl_vars['issue']->value['category'];?>
<br><code style="font-size:10px;"><?php echo $_smarty_tpl->tpl_vars['issue']->value['id'];?>
</code></small></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['issue']->value['description'];?>
</td>
                    <td><small><code><?php echo $_smarty_tpl->tpl_vars['issue']->value['suggestion'];?>
</code></small></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </table>

            <div class="summary-box 
                <?php if ($_smarty_tpl->tpl_vars['report']->value['score'] >= 75) {?>summary-good
                <?php } elseif ($_smarty_tpl->tpl_vars['report']->value['score'] >= 50) {?>summary-warn
                <?php } else { ?>summary-bad<?php }?>">
                <strong>审计摘要：</strong><?php echo $_smarty_tpl->tpl_vars['report']->value['summary'];?>

            </div>

            <?php } else { ?>
            <div style="text-align:center;padding:40px;color:#999;border:1px solid #e6e6e6;border-radius:6px;background:#fafafa;">
                加载审计报告失败，请重试
            </div>
            <?php }?>
        </article>
    </div>
</div>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
