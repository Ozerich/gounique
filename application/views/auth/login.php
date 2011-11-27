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
        <?=form_open("login");?>
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
</html>