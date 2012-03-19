<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <title><?if (isset($page_title)) echo $page_title;?> | Go Unique</title>
    <base href="<?=base_url()?>"/>

    <link rel="shortcut icon" href="img/favicon.png" />

    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet/less" href="css/cross_browser.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/main.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/reservierung.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/statistics.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/controlling.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/product.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/kundenverwaltung.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/arrows.css" type="text/css"/>
    <link type="text/css" href="css/cupertino/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <link type="text/css" href="css/jquery-livesearch.css" rel="stylesheet"/>
    <link type="text/css" href="css/ui.jqgrid.css" rel="stylesheet"/>

    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="js/global.js"></script>

    <script src="js/jquery-livesearch.js"></script>
    <script src="js/less-1.1.5.min.js"></script>
    <script src="js/locale/grid.locale-ru.js"></script>
    <script src="js/jquery.jqGrid.min.js"></script>
    <script src="js/jquery-validator.js"></script>
    <script src="js/validator-settings.js"></script>

    <? if (isset($JS_files))
    foreach ($JS_files as $js): ?>
        <script src="<?=$js?>"></script>
        <? endforeach; ?>
</head>
<body>

<div id="header">
    <span class="time"><?=date("d. F Y")?></span>
</div>

<div id="wrapper">

    <?=$page_content?>

</div>

<div id="footer-wr">

    <div id="footer-logo"></div>

    <div id="footer">

        <div class="username-block">
            <div class="username"> <?=$user->name . " - " . $user->surname?></div>
            <a href="logout" alt="Log out"><img src="img/logout.png"/></a>
            <br class="clear"/>
        </div>

        <span class="copyright">&copy; 2010 - 2012 Copyright <a href="#">goUnique</a> 1.4
   Powered by <a class="author-link" href="mailto:ozicoder@gmail.com">Vital Ozierski</a></span>

    </div>

</div>
<div id="dark-overlay"></div>
<div id="overlay-window"></div>
</body>
</html>
