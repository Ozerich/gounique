<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title><?if (isset($page_title)) echo $page_title;?> | Go Unique</title>
    <base href="<?=base_url()?>"/>

    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" title="no title"/>

    <link rel="stylesheet/less" href="css/main.less" type="text/css"/>
    <link rel="stylesheet/less" href="css/arrows.css" type="text/css"/>


    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/less-1.1.5.min.js"></script>

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

        <span class="username"> <?=$user->name . " - " . $user->surname?></span>

        <span class="copyright">&copy; 2010 - 2012 Copyright <a href="#">goUnique</a>.
    Powered by <a class="author-link" href="mailto:ozicoder@gmail.com">Vital Ozierski</a></span>

    </div>

</div>
</body>
</html>
