<?php /* Smarty version Smarty 3.1.4, created on 2011-10-25 19:29:39
         compiled from "Z:\home\localhost\www\hotel\templates\login.html" */ ?>
<?php /*%%SmartyHeaderCode:93854ea6e3f3aadc24-12735308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77da1879d6682e186c674ec72b4dcfdd6793ff65' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates\\login.html',
      1 => 1319451390,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93854ea6e3f3aadc24-12735308',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ea6e3f3afb22',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ea6e3f3afb22')) {function content_4ea6e3f3afb22($_smarty_tpl) {?><!DOCTYPE html>
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
                    <input type="text" name="email" value="" id="email" tabindex="1" placeholder="admin@admin"/>
                </div>

                <div class="field">
                    <label for="password">Password
                        <small><a href="javascript:;">Forgot Password?</a></small>
                    </label>
                    <input type="password" name="password" value="" id="password" tabindex="2" placeholder="admin"/>
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
</html><?php }} ?>