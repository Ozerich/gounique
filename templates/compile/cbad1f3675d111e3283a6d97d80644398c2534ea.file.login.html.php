<?php /* Smarty version Smarty-3.0.7, created on 2011-10-24 13:13:23
         compiled from "Z:\home\localhost\www\hotel\templates/login.html" */ ?>
<?php /*%%SmartyHeaderCode:293004ea53a43c2afe9-01211482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbad1f3675d111e3283a6d97d80644398c2534ea' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates/login.html',
      1 => 1319451118,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '293004ea53a43c2afe9-01211482',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Login | Dashboard Admin</title>
    <link rel="stylesheet" href="./css/reset.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="./css/text.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="./css/form.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="./css/buttons.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="./css/login.css" type="text/css" media="screen" title="no title"/>
</head>
<body>
<div id="login">
    <h1>Dashboard</h1>
    <div id="login_panel">
        <form action="login.php" method="post" accept-charset="utf-8">
            <div class="login_fields">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="" id="email" tabindex="1" placeholder="email@example.com"/>
                </div>

                <div class="field">
                    <label for="password">Password
                        <small><a href="javascript:;">Forgot Password?</a></small>
                    </label>
                    <input type="password" name="password" value="" id="password" tabindex="2" placeholder="password"/>
                </div>
            </div>
            <!-- .login_fields -->
            <div class="login_actions">
                <button type="submit" name="login-submit" class="btn btn-black" tabindex="3">Login</button>
            </div>
        </form>
    </div>
    <!-- #login_panel -->
</div>
<!-- #login -->
</body>
</html>