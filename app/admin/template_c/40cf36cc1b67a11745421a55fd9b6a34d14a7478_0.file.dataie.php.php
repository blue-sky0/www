<?php
/* Smarty version 3.1.32, created on 2026-06-25 10:19:55
  from '/home/sky/www/app/admin/view/dataie.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3d00cb07c032_28114241',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '40cf36cc1b67a11745421a55fd9b6a34d14a7478' => 
    array (
      0 => '/home/sky/www/app/admin/view/dataie.php',
      1 => 1782382673,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3d00cb07c032_28114241 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据导入导出 - 后台管理系统</title>
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
        .ie-container { display: flex; gap: 20px; flex-wrap: wrap; }
        .ie-panel { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; flex: 1; min-width: 300px; }
        .ie-panel h3 { margin: 0 0 15px 0; font-size: 16px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 10px; }
        .ie-panel h3 i { margin-right: 8px; color: #409eff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 13px; color: #666; font-weight: bold; }
        .form-group select, .form-group input[type="file"], .form-group input[type="url"], .form-group input[type="text"] { width: 100%; padding: 8px 12px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
        .form-group select:focus, .form-group input:focus { border-color: #409eff; outline: none; }
        .btn { display: inline-block; padding: 8px 20px; border-radius: 4px; font-size: 14px; cursor: pointer; border: 1px solid transparent; text-decoration: none; }
        .btn-primary { background: #409eff; color: #fff; border-color: #409eff; }
        .btn-primary:hover { background: #66b1ff; }
        .btn-success { background: #67c23a; color: #fff; border-color: #67c23a; }
        .btn-success:hover { background: #85ce61; }
        .btn-warning { background: #e6a23c; color: #fff; border-color: #e6a23c; }
        .btn-warning:hover { background: #ebb563; }
        .btn-info { background: #909399; color: #fff; border-color: #909399; }
        .btn-info:hover { background: #a6a9ad; }
        .btn-danger { background: #f56c6c; color: #fff; border-color: #f56c6c; }
        .btn-danger:hover { background: #f78989; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn + .btn { margin-left: 8px; }
        .schema-box { margin-top: 15px; background: #fafafa; border: 1px solid #eee; border-radius: 4px; padding: 12px; max-height: 200px; overflow-y: auto; }
        .schema-box table { width: 100%; font-size: 12px; border-collapse: collapse; }
        .schema-box th { background: #f5f7fa; padding: 6px 8px; text-align: left; font-weight: normal; color: #666; border-bottom: 1px solid #e4e7ed; }
        .schema-box td { padding: 5px 8px; border-bottom: 1px solid #f2f2f2; }
        .schema-box .pk { color: #e6a23c; font-weight: bold; }
        .schema-box .ai { color: #67c23a; }
        .ml-10 { margin-left: 10px; }
        .mt-10 { margin-top: 10px; }
        .text-muted { color: #999; font-size: 12px; }
        .format-btns { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
        .file-info { font-size: 12px; color: #666; margin-top: 5px; }
        .preview-section { background: #fff; border: 1px solid #e6e6e6; border-radius: 6px; padding: 20px; margin-top: 20px; }
        .preview-section h3 { margin: 0 0 15px 0; font-size: 16px; color: #333; border-bottom: 1px solid #f2f2f2; padding-bottom: 10px; }
        .table-responsive { overflow-x: auto; }
        .table-responsive table { width: 100%; font-size: 13px; border-collapse: collapse; }
        .table-responsive th { background: #f5f7fa; padding: 8px 10px; text-align: left; font-weight: normal; color: #666; border-bottom: 2px solid #e4e7ed; white-space: nowrap; }
        .table-responsive td { padding: 6px 10px; border-bottom: 1px solid #f2f2f2; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .table-responsive tr:hover td { background: #f5f7fa; }
        .pagination { display: flex; justify-content: center; gap: 5px; margin-top: 10px; font-size: 13px; }
        .pagination a, .pagination span { padding: 4px 10px; border: 1px solid #dcdfe6; border-radius: 3px; text-decoration: none; color: #333; }
        .pagination a:hover { background: #409eff; color: #fff; border-color: #409eff; }
        .pagination .current { background: #409eff; color: #fff; border-color: #409eff; }
        .section-tabs { display: flex; gap: 0; margin-bottom: 20px; border-bottom: 2px solid #e6e6e6; }
        .section-tab { padding: 10px 24px; cursor: pointer; color: #666; font-size: 14px; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .3s; }
        .section-tab:hover { color: #409eff; }
        .section-tab.active { color: #409eff; border-bottom-color: #409eff; }
        .section-content { display: none; }
        .section-content.active { display: block; }
        .import-options { margin: 10px 0; padding: 10px; background: #fafafa; border-radius: 4px; }
        .import-options label { margin-right: 15px; cursor: pointer; font-size: 13px; }
        .import-options input[type="radio"] { margin-right: 4px; vertical-align: middle; }
        .fetch-preview { background: #fafafa; border: 1px solid #eee; border-radius: 4px; padding: 10px; max-height: 300px; overflow-y: auto; font-size: 13px; line-height: 1.8; }
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MainTitledata']->value, 'item');
$_smarty_tpl->tpl_vars['item']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->index++;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <?php if ($_smarty_tpl->tpl_vars['item']->index < 4) {?>
                        <li><form action="/" method="post"><input type="hidden" name="p" value="admin"><input type="hidden" name="c" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['types'];?>
"><input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
"><a href="/" onclick="this.parentNode.submit(); return false;"><?php echo $_smarty_tpl->tpl_vars['item']->value['course'];?>
</a></form></li>
                    <?php }?>
                <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
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
$_smarty_tpl->tpl_vars['item']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->index++;
$__foreach_item_1_saved = $_smarty_tpl->tpl_vars['item'];
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
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
        </aside>
        <article>
            <div class="text"><h2>数据导入导出</h2></div>

            <?php if (!empty($_smarty_tpl->tpl_vars['success_msg']->value)) {?>
                <div class="msg-success"><?php echo $_smarty_tpl->tpl_vars['success_msg']->value;?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 4000);<?php echo '</script'; ?>
>
            <?php }?>
            <?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
                <div class="msg-error"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
                <?php echo '<script'; ?>
>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 4000);<?php echo '</script'; ?>
>
            <?php }?>

            <div class="form-group" style="max-width: 400px;">
                <label for="tableSelect">选择数据表</label>
                <select id="tableSelect" onchange="onTableChange(this.value)">
                    <option value="">-- 请选择 --</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tables']->value, 't');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
">S_<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
</option>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </select>
                <span class="text-muted mt-10" id="rowCountInfo" style="display:none;"></span>
            </div>

            <div id="schemaContainer" class="schema-box" style="display:none;"></div>

            <div class="section-tabs" id="sectionTabs" style="display:none;">
                <div class="section-tab active" data-section="export" onclick="switchSection('export')">
                    <i class="fa-solid fa-download"></i> 导出数据
                </div>
                <div class="section-tab" data-section="import" onclick="switchSection('import')">
                    <i class="fa-solid fa-upload"></i> 导入数据
                </div>
                <div class="section-tab" data-section="fetch" onclick="switchSection('fetch')">
                    <i class="fa-solid fa-globe"></i> 网络导入
                </div>
                <div class="section-tab" data-section="manage" onclick="switchSection('manage')">
                    <i class="fa-solid fa-wrench"></i> 表管理
                </div>
            </div>

            <div id="sectionExport" class="section-content active">
                <div class="ie-panel">
                    <h3><i class="fa-solid fa-download"></i> 导出数据</h3>
                    <p class="text-muted">将当前表数据导出为 CSV、Excel 或 SQL 格式。</p>
                    <div class="format-btns">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="doExport('csv')">
                            <i class="fa-solid fa-file-csv"></i> 导出 CSV
                        </a>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="doExport('excel')">
                            <i class="fa-solid fa-file-excel"></i> 导出 Excel
                        </a>
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="doExport('sql')">
                            <i class="fa-solid fa-database"></i> 导出 SQL
                        </a>
                    </div>
                </div>
            </div>

            <div id="sectionImport" class="section-content">
                <div class="ie-panel">
                    <h3><i class="fa-solid fa-upload"></i> 导入数据</h3>
                    <p class="text-muted">上传文件导入数据到当前表。支持的格式：CSV、Excel(.xlsx/.xls)、SQL。</p>

                    <div class="import-options">
                        <strong style="font-size:13px;">导入模式：</strong><br>
                        <label><input type="radio" name="importType" value="insert" checked> 仅插入</label>
                        <label><input type="radio" name="importType" value="replace"> 替换（REPLACE）</label>
                        <label><input type="radio" name="importType" value="update"> 更新（ON DUPLICATE KEY UPDATE）</label>
                    </div>

                    <form method="POST" enctype="multipart/form-data" action="index.php?p=admin&c=DataIE&a=import">
                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                        <input type="hidden" name="table" id="importTable" value="">
                        <input type="hidden" name="importType" id="importTypeInput" value="insert">

                        <div class="form-group">
                            <label>选择文件</label>
                            <input type="file" name="file" id="importFile" accept=".csv,.xlsx,.xls,.sql" required onchange="updateFileInfo(this)">
                            <div class="file-info" id="fileInfo"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="importBtn" onclick="return confirm('确认导入数据到当前表？建议先导出备份。')" disabled>
                            <i class="fa-solid fa-upload"></i> 开始导入
                        </button>
                        <a href="javascript:void(0)" class="btn btn-info btn-sm ml-10" onclick="downloadTemplate()">
                            <i class="fa-solid fa-download"></i> 下载导入模板
                        </a>
                    </form>
                </div>
            </div>

            <div id="sectionFetch" class="section-content">
                <div class="ie-panel">
                    <h3><i class="fa-solid fa-globe"></i> 从网址抓取内容</h3>

                    <div class="form-group">
                        <label>目标网址</label>
                        <div style="display:flex;gap:8px;">
                            <input type="url" id="fetchUrl" placeholder="https://example.com/article/123" style="flex:1;">
                            <button type="button" class="btn btn-primary" onclick="analyzeUrl()">
                                <i class="fa-solid fa-search"></i> 分析内容
                            </button>
                        </div>
                        <div class="text-muted" style="margin-top:5px;font-size:12px;">支持标准 HTML 页面，自动提取标题和正文</div>
                    </div>

                    <div id="fetchLoading" style="display:none;text-align:center;padding:20px;">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#409eff;"></i>
                        <div style="margin-top:10px;color:#666;">正在抓取网页内容...</div>
                    </div>

                    <div id="fetchError" style="display:none;color:#f56c6c;padding:10px;background:#fef0f0;border-radius:4px;"></div>

                    <div id="fetchResult" style="display:none;">
                        <div class="form-group">
                            <label>学科分类</label>
                            <select id="fetchSubject">
                                <option value="">-- 选择学科 --</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['subjects']->value, 's');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['s']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['s']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value;?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>页面标识（Slug）</label>
                            <input type="text" id="fetchPage" placeholder="article-slug" style="width:300px;">
                        </div>

                        <div class="form-group">
                            <label>标题</label>
                            <div id="fetchTitle" style="padding:8px;background:#f5f7fa;border-radius:4px;font-weight:bold;"></div>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" id="downloadImages" checked> 下载图片到本地</label>
                        </div>

                        <div class="form-group">
                            <label>正文预览</label>
                            <div class="fetch-preview" id="fetchContentPreview"></div>
                            <input type="hidden" id="fetchContent">
                        </div>

                        <div id="fetchImagesBox" style="display:none;">
                            <label>检测到的图片（共 <span id="fetchImagesCount">0</span> 张）</label>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;" id="fetchImagesList"></div>
                        </div>

                        <button type="button" class="btn btn-success" onclick="doFetch()" id="fetchSubmitBtn" disabled>
                            <i class="fa-solid fa-upload"></i> 导入到数据库
                        </button>
                    </div>
                </div>
            </div>

            <div id="sectionManage" class="section-content">
                <div class="ie-panel">
                    <h3><i class="fa-solid fa-wrench"></i> 表管理</h3>
                    <p class="text-muted">清空表数据（谨慎操作，建议先导出备份）。</p>
                    <div class="import-options" id="clearConfirmBox" style="display:none;">
                        <form method="POST" action="index.php?p=admin&c=DataIE&a=clearTable" onsubmit="return confirm('清空操作不可恢复，确定继续？')">
                            <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <input type="hidden" name="table" id="clearTable" value="">
                            <div class="form-group">
                                <label>请输入确认文本：<strong id="confirmTextLabel" style="color:#f56c6c;"></strong></label>
                                <input type="text" name="confirm_text" id="confirmText" style="width:300px;" placeholder="输入确认文本" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash-can"></i> 确认清空
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="preview-section" id="previewSection" style="display:none;">
                <h3>
                    <i class="fa-solid fa-eye"></i> 数据预览
                    <span class="text-muted" id="previewInfo" style="font-weight:normal;"></span>
                </h3>
                <div id="previewTableContainer">
                    <div class="text-muted" style="padding: 20px; text-align: center;">请先选择数据表</div>
                </div>
                <div class="pagination" id="previewPagination"></div>
            </div>
        </article>
    </div>
</div>

<?php echo '<script'; ?>
>
var currentTable = '';
var currentPage = 1;
var totalPages = 1;

function onTableChange(tableName) {
    currentTable = tableName;
    currentPage = 1;

    if (!tableName) {
        $('#schemaContainer').hide();
        $('#sectionTabs').hide();
        $('#previewSection').hide();
        $('#clearConfirmBox').hide();
        return;
    }

    $('#sectionTabs').show();
    $('#importTable').val(tableName);
    $('#clearTable').val(tableName);

    var clearText = 'CONFIRM_CLEAR_' + tableName.toUpperCase();
    $('#confirmTextLabel').text(clearText);
    $('#confirmText').attr('placeholder', '输入: ' + clearText);
    $('#clearConfirmBox').show();

    loadSchema(tableName);
    loadPreview(tableName, 1);
}

function loadSchema(tableName) {
    $.getJSON('index.php?p=admin&c=DataIE&a=schema', { table: tableName }, function(res) {
        if (res.error) {
            $('#schemaContainer').html('<span style="color:#f56c6c;">' + res.error + '</span>').show();
            return;
        }

        var html = '<table><thead><tr><th>字段</th><th>类型</th><th>Null</th><th>默认</th></tr></thead><tbody>';
        $.each(res.columns, function(i, col) {
            var flags = '';
            if (col.key === 'PRI') flags += '<span class="pk">[PK]</span> ';
            if (col.extra === 'auto_increment') flags += '<span class="ai">[AI]</span> ';
            html += '<tr><td>' + flags + col.field + '</td><td>' + col.type + '</td><td>' +
                    (col.null === 'YES' ? '是' : '否') + '</td><td>' +
                    (col.default !== null ? col.default : '<span style="color:#ccc;">-</span>') + '</td></tr>';
        });
        html += '</tbody></table>';

        $('#schemaContainer').html(html).show();
        $('#rowCountInfo').text('共 ' + res.rowCount + ' 条记录').show();
    });
}

function loadPreview(tableName, page) {
    $.getJSON('index.php?p=admin&c=DataIE&a=preview', { table: tableName, page: page }, function(res) {
        if (res.error || !res.data || res.data.length === 0) {
            $('#previewSection').show();
            $('#previewTableContainer').html('<div class="text-muted" style="padding: 20px; text-align: center;">暂无数据</div>');
            $('#previewPagination').empty();
            return;
        }

        currentPage = res.page;
        totalPages = res.totalPages;
        $('#previewInfo').text('(共 ' + res.total + ' 条，第 ' + res.page + '/' + res.totalPages + ' 页)');

        var headers = Object.keys(res.data[0]);
        var html = '<div class="table-responsive"><table><thead><tr>';
        $.each(headers, function(i, h) {
            html += '<th>' + h + '</th>';
        });
        html += '</tr></thead><tbody>';
        $.each(res.data, function(i, row) {
            html += '<tr>';
            $.each(headers, function(j, h) {
                var val = row[h];
                if (val === null || val === undefined) val = '<span style="color:#ccc;">NULL</span>';
                else val = $('<span>').text(val).html();
                html += '<td title="' + val + '">' + val + '</td>';
            });
            html += '</tr>';
        });
        html += '</tbody></table></div>';
        $('#previewTableContainer').html(html);

        var pager = '';
        if (res.totalPages > 1) {
            if (res.page > 1) {
                pager += '<a href="javascript:void(0)" onclick="loadPreview(\'' + tableName + '\', ' + (res.page - 1) + ')">上一页</a>';
            }
            for (var p = Math.max(1, res.page - 2); p <= Math.min(res.totalPages, res.page + 2); p++) {
                pager += p === res.page ? '<span class="current">' + p + '</span>' : '<a href="javascript:void(0)" onclick="loadPreview(\'' + tableName + '\', ' + p + ')">' + p + '</a>';
            }
            if (res.page < res.totalPages) {
                pager += '<a href="javascript:void(0)" onclick="loadPreview(\'' + tableName + '\', ' + (res.page + 1) + ')">下一页</a>';
            }
        }
        $('#previewPagination').html(pager);
        $('#previewSection').show();
    });
}

function switchSection(section) {
    $('.section-tab').removeClass('active');
    $('.section-tab[data-section="' + section + '"]').addClass('active');
    $('.section-content').removeClass('active');
    $('#section' + section.charAt(0).toUpperCase() + section.slice(1)).addClass('active');
}

function doExport(format) {
    if (!currentTable) {
        alert('请先选择数据表');
        return;
    }
    var form = $('<form method="GET" action="index.php">');
    form.append('<input type="hidden" name="p" value="admin">');
    form.append('<input type="hidden" name="c" value="DataIE">');
    form.append('<input type="hidden" name="a" value="export">');
    form.append('<input type="hidden" name="table" value="' + currentTable + '">');
    form.append('<input type="hidden" name="format" value="' + format + '">');
    form.append('<input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">');
    form.appendTo('body').submit();
}

$('input[name="importType"]').on('change', function() {
    $('#importTypeInput').val($(this).val());
});

function updateFileInfo(input) {
    var file = input.files[0];
    if (file) {
        var sizeStr = file.size > 1024 * 1024 ? (file.size / 1024 / 1024).toFixed(2) + ' MB' : (file.size / 1024).toFixed(1) + ' KB';
        $('#fileInfo').text('文件名: ' + file.name + ' | 大小: ' + sizeStr);
        $('#importBtn').prop('disabled', false);
    } else {
        $('#fileInfo').empty();
        $('#importBtn').prop('disabled', true);
    }
}

function downloadTemplate() {
    if (!currentTable) {
        alert('请先选择数据表');
        return;
    }
    window.location.href = 'index.php?p=admin&c=DataIE&a=template&table=' + currentTable + '&csrf_token=<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
';
}

function analyzeUrl() {
    var url = $('#fetchUrl').val().trim();
    if (!url) { alert('请输入网址'); return; }

    $('#fetchLoading').show();
    $('#fetchResult').hide();
    $('#fetchError').hide();
    $('#fetchSubmitBtn').prop('disabled', true);

    $.getJSON('index.php?p=admin&c=DataIE&a=analyzeUrl', { url: url }, function(res) {
        $('#fetchLoading').hide();
        if (res.error) {
            $('#fetchError').text(res.error).show();
            return;
        }

        $('#fetchTitle').text(res.title || '（无标题）');
        var slug = res.title ? res.title.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim() : 'untitled';
        $('#fetchPage').val(slug);
        $('#fetchContent').val(res.content);

        var tmp = document.createElement('div');
        tmp.innerHTML = res.content;
        $('script, style', tmp).remove();
        var previewText = tmp.innerHTML.substring(0, 2000);
        if (tmp.innerHTML.length > 2000) previewText += '...';
        $('#fetchContentPreview').html(previewText);

        if (res.images && res.images.length > 0) {
            var imgHtml = '';
            for (var i = 0; i < res.images.length; i++) {
                imgHtml += '<img src="' + res.images[i].src + '" style="width:80px;height:60px;object-fit:cover;border:1px solid #eee;border-radius:4px;margin:2px;" title="' + res.images[i].src + '">';
            }
            $('#fetchImagesList').html(imgHtml);
            $('#fetchImagesCount').text(res.images.length);
            $('#fetchImagesBox').show();
        } else {
            $('#fetchImagesBox').hide();
        }

        $('#fetchResult').show();
        $('#fetchSubmitBtn').prop('disabled', false);
    }).fail(function() {
        $('#fetchLoading').hide();
        $('#fetchError').text('网络请求失败，请检查网址是否可访问').show();
    });
}

function doFetch() {
    var subject = $('#fetchSubject').val();
    var page = $('#fetchPage').val().trim();
    var content = $('#fetchContent').val();
    var url = $('#fetchUrl').val().trim();
    var downloadImages = $('#downloadImages').prop('checked') ? 1 : 0;

    if (!subject) { alert('请选择学科'); return; }
    if (!page) { alert('请填写页面标识'); return; }
    if (!content) { alert('没有可导入的内容'); return; }

    $('#fetchSubmitBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> 导入中...');

    $.post('index.php?p=admin&c=DataIE&a=doFetch', {
        csrf_token: '<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
',
        url: url,
        subject: subject,
        page: page,
        content: content,
        download_images: downloadImages
    }, function(res) {
        $('#fetchSubmitBtn').prop('disabled', false).html('<i class="fa-solid fa-upload"></i> 导入到数据库');
        if (res.success) {
            alert('导入成功！共下载 ' + (res.images ? res.images.length : 0) + ' 张图片');
            location.reload();
        } else {
            alert('导入失败：' + res.error);
        }
    }, 'json');
}
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
