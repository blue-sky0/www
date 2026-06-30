<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录</title>
    <link rel="shortcut icon" href="../../images/admin.jpg" />
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/fontawesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.7.2-web/css/all.min.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
            margin: 0;
        }
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            width: 360px;
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .login-box .field {
            margin-bottom: 20px;
        }
        .login-box label {
            display: block;
            margin-bottom: 6px;
            color: #666;
            font-size: 14px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdfe6;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .login-box input[type="text"]:focus,
        .login-box input[type="password"]:focus {
            border-color: #409eff;
            outline: none;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #409eff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-box button:hover {
            background: #337ecc;
        }
        .login-box .error {
            color: #f56c6c;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2><i class="fa-solid fa-shield-halved"></i> 后台管理登录</h2>
        {if $error neq ''}
            <div class="error">{$error}</div>
        {/if}
        <form method="post" action="">
            <input type="hidden" name="p" value="admin">
            <input type="hidden" name="c" value="Auth">
            <input type="hidden" name="a" value="login">
            <input type="hidden" name="csrf_token" value="{$csrf_token}">
            <div class="field">
                <label>用户名</label>
                <input type="text" name="username" placeholder="请输入用户名" required>
            </div>
            <div class="field">
                <label>密码</label>
                <input type="password" name="password" placeholder="请输入密码" required>
            </div>
            <button type="submit">登 录</button>
        </form>
    </div>
</body>
</html>
