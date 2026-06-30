<!DOCTYPE html>
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
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>
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
                    <h2>系统设置</h2>
                </div>

                {if $smarty.session.success_msg neq ''}
                    <div class="msg-success">{$smarty.session.success_msg}</div>
                    <script>setTimeout(function(){ document.querySelector('.msg-success').style.display='none'; }, 3000);</script>
                    {$_SESSION['success_msg'] = ''}
                {/if}
                {if $smarty.session.error_msg neq ''}
                    <div class="msg-error">{$smarty.session.error_msg}</div>
                    <script>setTimeout(function(){ document.querySelector('.msg-error').style.display='none'; }, 3000);</script>
                    {$_SESSION['error_msg'] = ''}
                {/if}

                <ul class="settings-tabs">
                    <li><a href="index.php?p=admin&c=Settings&section=general" class="{if $activeSection eq 'general'}active{/if}">基本设置</a></li>
                    <li><a href="index.php?p=admin&c=Settings&section=mail" class="{if $activeSection eq 'mail'}active{/if}">邮件设置</a></li>
                    <li><a href="index.php?p=admin&c=Settings&section=third_party" class="{if $activeSection eq 'third_party'}active{/if}">第三方集成</a></li>
                </ul>

                {if $activeSection eq 'general'}
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <input type="hidden" name="section" value="general">

                    <div class="field">
                        <label>网站名称</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_name]" value="{$settings.general.site_name}"></div>
                    </div>
                    <div class="field">
                        <label>网站LOGO</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_logo]" value="{$settings.general.site_logo}" placeholder="图片URL路径"></div>
                    </div>
                    <div class="field">
                        <label>SEO关键词</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_keywords]" value="{$settings.general.site_keywords}"></div>
                    </div>
                    <div class="field">
                        <label>网站描述</label>
                        <div class="input-wrap"><textarea name="settings[general][site_description]">{$settings.general.site_description}</textarea></div>
                    </div>
                    <div class="field">
                        <label>ICP备案号</label>
                        <div class="input-wrap"><input type="text" name="settings[general][site_icp]" value="{$settings.general.site_icp}"></div>
                    </div>
                    <div class="field">
                        <label>联系邮箱</label>
                        <div class="input-wrap"><input type="email" name="settings[general][contact_email]" value="{$settings.general.contact_email}"></div>
                    </div>
                    <div class="field">
                        <label>联系电话</label>
                        <div class="input-wrap"><input type="text" name="settings[general][contact_phone]" value="{$settings.general.contact_phone}"></div>
                    </div>
                    <div class="field">
                        <label>联系地址</label>
                        <div class="input-wrap"><input type="text" name="settings[general][contact_address]" value="{$settings.general.contact_address}"></div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>

                {elseif $activeSection eq 'mail'}
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <input type="hidden" name="section" value="mail">

                    <div class="field">
                        <label>SMTP服务器</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][smtp_host]" value="{$settings.mail.smtp_host}" placeholder="smtp.example.com"></div>
                    </div>
                    <div class="field">
                        <label>SMTP端口</label>
                        <div class="input-wrap"><input type="number" name="settings[mail][smtp_port]" value="{$settings.mail.smtp_port}"><div class="form-text">常用端口：25(无加密), 465(SSL), 587(TLS)</div></div>
                    </div>
                    <div class="field">
                        <label>用户名</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][smtp_user]" value="{$settings.mail.smtp_user}"></div>
                    </div>
                    <div class="field">
                        <label>密码</label>
                        <div class="input-wrap"><input type="password" name="settings[mail][smtp_pass]" value="{$settings.mail.smtp_pass}" autocomplete="new-password"></div>
                    </div>
                    <div class="field">
                        <label>加密方式</label>
                        <div class="input-wrap">
                            <select name="settings[mail][smtp_encryption]">
                                <option value="none" {if $settings.mail.smtp_encryption eq 'none'}selected{/if}>无</option>
                                <option value="tls" {if $settings.mail.smtp_encryption eq 'tls'}selected{/if}>TLS</option>
                                <option value="ssl" {if $settings.mail.smtp_encryption eq 'ssl'}selected{/if}>SSL</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label>发件人邮箱</label>
                        <div class="input-wrap"><input type="email" name="settings[mail][from_email]" value="{$settings.mail.from_email}"></div>
                    </div>
                    <div class="field">
                        <label>发件人名称</label>
                        <div class="input-wrap"><input type="text" name="settings[mail][from_name]" value="{$settings.mail.from_name}"></div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>

                {elseif $activeSection eq 'third_party'}
                <form action="/" method="post" class="settings-form">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="save">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <input type="hidden" name="section" value="third_party">

                    <div class="field">
                        <label>百度统计代码</label>
                        <div class="input-wrap">
                            <textarea name="settings[third_party][baidu_tongji]">{$settings.third_party.baidu_tongji}</textarea>
                            <div class="form-text">填入百度统计提供的JS代码</div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Google Analytics</label>
                        <div class="input-wrap">
                            <textarea name="settings[third_party][google_analytics]">{$settings.third_party.google_analytics}</textarea>
                        </div>
                    </div>
                    <div class="field">
                        <label></label>
                        <div class="input-wrap"><input class="input-sub" type="submit" value="保存设置"></div>
                    </div>
                </form>
                {/if}

                {if $activeSection eq 'mail'}
                <div style="margin-top:30px; border:1px solid #dcdfe6; border-radius:6px; padding:20px; max-width:700px; background:#fafafa;">
                    <h3>测试邮件发送</h3>
                    <form action="/" method="post" class="settings-form">
                        <input type="hidden" name="p" value="admin">
                        <input type="hidden" name="c" value="Settings">
                        <input type="hidden" name="a" value="testMail">
                        <input type="hidden" name="csrf_token" value="{$csrf_token}">
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
                {/if}

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e6e6e6;">
                <h3>系统维护</h3>
                <form action="/" method="post" onsubmit="return confirm('确定要清除模板缓存吗？')">
                    <input type="hidden" name="p" value="admin">
                    <input type="hidden" name="c" value="Settings">
                    <input type="hidden" name="a" value="clearCache">
                    <input type="hidden" name="csrf_token" value="{$csrf_token}">
                    <input class="input-sub input-sub-warning" type="submit" value="清除模板缓存">
                </form>
            </article>
        </div>
    </div>
</body>
</html>
