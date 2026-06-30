<?php
/* Smarty version 3.1.32, created on 2026-06-25 08:56:39
  from '/home/sky/www/app/admin/view/settings.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6a3ced473b8cc0_58278780',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f80ea59c9d17afed4d675c0caa5bd9e5acfe2c2d' => 
    array (
      0 => '/home/sky/www/app/admin/view/settings.php',
      1 => 1782377774,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a3ced473b8cc0_58278780 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统设置 - 后台管理系统</title>
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
        .settings-tabs { margin-bottom: 20px; border-bottom: 2px solid #e6e6e6; padding: 0; list-style: none; }
        .settings-tabs li { display: inline-block; margin-bottom: -2px; }
        .settings-tabs a { display: block; padding: 10px 20px; text-decoration: none; color: #666; border-bottom: 2px solid transparent; font-size: 14px; }
        .settings-tabs a.active { color: #409eff; border-bottom-color: #409eff; font-weight: bold; }
        .settings-form { max-width: 700px; }
        .settings-form .field { margin-bottom: 18px; display: flex; align-items: flex-start; }
        .settings-form .field label { width: 120px; min-width: 120px; padding-top: 8px; color: #666; font-size: 14px; text-align: right; padding-right: 15px; }
        .settings-form .field .input-wrap { flex: 1; }
        .settings-form .field input[type="text"],
        .settings-form .field input[type="email"],
        .settings-form .field input[type="number"],
        .settings-form .field input[type="password"],
        .settings-form .field select,
        .settings-form .field textarea { width: 100%; padding: 8px 10px; border: 1px solid #dcdfe6; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
        .settings-form .field textarea { min-height: 80px; resize: vertical; font-family: monospace; }
        .settings-form .field select { height: 36px; }
        .settings-form .field .form-text { font-size: 12px; color: #999; margin-top: 4px; }
        .msg-success { padding: 10px 15px; background: #f0f9eb; border: 1px solid #e1f3d8; color: #67c23a; border-radius: 4px; margin-bottom: 15px; }
        .msg-error { padding: 10px 15px; background: #fef0f0; border: 1px solid #fde2e2; color: #f56c6c; border-radius: 4px; margin-bottom: 15px; }
        .input-sub { background: #409eff; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .input-sub:hover { background: #337ecc; }
        .input-sub-warning { background: #e6a23c; }
        .input-sub-warning:hover { background: #cf9236; }
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
                <div class="text">
                    <h2>系统设置</h2>
                </div>

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

                <ul class="settings-tabs">
                    <li><a href="index.php?p=admin&c=Settings&section=general" class="<?php if ($_smarty_tpl->tpl_vars['activeSection']->value == 'general') {?>active<?php }?>">基本设置</a></li>
                    <li><a href="index.php?p=admin&c=Settings&section=mail" class="<?php if ($_smarty_tpl->tpl_vars['activeSection']->value == 'mail') {?>active<?php }?>">邮件设置</a></li>
                    <li><a href="index.php?p=admin&c=Settings&section=third_party" class="<?php if ($_smarty_tpl->tpl_vars['activeSection']->value == 'third_party') {?>active<?php }?>">第三方集成</a></li>
                </ul>

                <?php if ($_smarty_tpl->tpl_vars['activeSection']->value == 'general') {?>
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <input type="hidden" name="section" value="general">

                    <div class="field">
                        <label>网站名称</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_name]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['site_name'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>网站LOGO</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_logo]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['site_logo'];?>
" placeholder="图片URL路径"></div>
                    </div>
                    <div class="field">
                        <label>SEO关键词</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_keywords]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['site_keywords'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>网站描述</label>
                        <div class="input-wrap"><textarea name="settings[general][site_description]"><?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['site_description'];?>
</textarea></div>
                    </div>
                    <div class="field">
                        <label>ICP备案号</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_icp]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['site_icp'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>联系邮箱</label>
                        <div class="input-wrap"><input type="email" name="settings[general][contact_email]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['contact_email'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>联系电话</label>
                        <div class="input-wrap"><input type="text" name="settings[general][contact_phone]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['contact_phone'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>联系地址</label>
                        <div class="input-wrap"><input type="text" name="settings[general][contact_address]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['general']['contact_address'];?>
"></div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>

                <?php } elseif ($_smarty_tpl->tpl_vars['activeSection']->value == 'mail') {?>
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <input type="hidden" name="section" value="mail">

                    <div class="field">
                        <label>SMTP服务器</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][smtp_host]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_host'];?>
" placeholder="smtp.example.com"></div>
                    </div>
                    <div class="field">
                        <label>SMTP端口</label>
                        <div class="input-wrap"><input type="number" name="settings[mail][smtp_port]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_port'];?>
"><div class="form-text">常用端口：25(无加密), 465(SSL), 587(TLS)</div></div>
                    </div>
                    <div class="field">
                        <label>用户名</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][smtp_user]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_user'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>密码</label>
                        <div class="input-wrap"><input type="password" name="settings[mail][smtp_pass]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_pass'];?>
" autocomplete="new-password"></div>
                    </div>
                    <div class="field">
                        <label>加密方式</label>
                        <div class="input-wrap">
                            <select name="settings[mail][smtp_encryption]">
                                <option value="none" <?php if ($_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_encryption'] == 'none') {?>selected<?php }?>>无</option>
                                <option value="tls" <?php if ($_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_encryption'] == 'tls') {?>selected<?php }?>>TLS</option>
                                <option value="ssl" <?php if ($_smarty_tpl->tpl_vars['settings']->value['mail']['smtp_encryption'] == 'ssl') {?>selected<?php }?>>SSL</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label>发件人邮箱</label>
                        <div class="input-wrap"><input type="email" name="settings[mail][from_email]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['from_email'];?>
"></div>
                    </div>
                    <div class="field">
                        <label>发件人名称</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][from_name]" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value['mail']['from_name'];?>
"></div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>

                <?php } elseif ($_smarty_tpl->tpl_vars['activeSection']->value == 'third_party') {?>
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <input type="hidden" name="section" value="third_party">

                    <div class="field">
                        <label>百度统计代码</label>
                        <div class="input-wrap">
                            <textarea name="settings[third_party][baidu_tongji]"><?php echo $_smarty_tpl->tpl_vars['settings']->value['third_party']['baidu_tongji'];?>
</textarea>
                            <div class="form-text">填入百度统计提供的JS代码</div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Google Analytics</label>
                        <div class="input-wrap">
                            <textarea name="settings[third_party][google_analytics]"><?php echo $_smarty_tpl->tpl_vars['settings']->value['third_party']['google_analytics'];?>
</textarea>
                        </div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['activeSection']->value == 'mail') {?>
                <div style="margin-top:30px; border:1px solid #dcdfe6; border-radius:6px; padding:20px; max-width:700px; background:#fafafa;">
                    <h3>测试邮件发送</h3>
                    <form action="/" method="post" class="settings-form">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Settings">
                        <input type="hidden" name="a" value="testMail">
                        <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                        <div class="field">
                            <label>测试邮箱</label>
                            <div class="input-wrap">
                                <input type="email" name="test_email" required placeholder="输入接收测试邮件的邮箱地址">
                                <div class="form-text">点击发送后将向此邮箱发送一封测试邮件</div>
                            </div>
                        </div>
                        <div class="field">
                            <label></label>
                            <div class="input-wrap"><input style="background:#67c23a;" class="input-sub" type="submit" value="发送测试邮件"></div>
                        </div>
                    </form>
                </div>
                <?php }?>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e6e6e6;">
                <h3>系统维护</h3>
                <form action="/" method="post" onsubmit="return confirm('确定要清除模板缓存吗？')">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="clearCache">
                    <input type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                    <input class="input-sub input-sub-warning" type="submit" value="清除模板缓存">
                </form>
            </article>
        </div>
    </div>
</body>
</html>
<?php }
}
