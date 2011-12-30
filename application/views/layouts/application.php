<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title><?if(isset($page_title)) echo $page_title;?> | Go Unique</title>
    <base href="<?=base_url()?>"/>

    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/text.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/form.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/main.css" type="text/css"/>
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print"/>

    <script src="js/jquery/jquery-1.6.4.min.js"></script>
    <script src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="js/global.js"></script>
    <script src="js/misc/excanvas.min.js"></script>
    <script src="js/jquery/facebox.js"></script>
    <script src="js/jquery/jquery.visualize.js"></script>
    <script src="js/jquery/jquery.dataTables.min.js"></script>
    <script src="js/jquery/jquery.tablesorter.min.js"></script>
    <script src="js/jquery/jquery.uniform.min.js"></script>
    <script src="js/jquery/jquery.placeholder.min.js"></script>
    <script src="js/widgets.js"></script>

    <? if (isset($JS_files))
    foreach ($JS_files as $js): ?>
        <script src="<?=$js?>"></script>
        <? endforeach; ?>

    <link rel="stylesheet" href="css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" media="screen"
          title="no title"/>
    <link rel="stylesheet" href="css/plugin/jquery.visualize.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/facebox.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/uniform.default.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/dataTables.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" title="no title">

</head>

<div id="wrapper">
    <div id="top">
        <div class="content-wr">
            <ul class="right">
                <li><a href="#" class="top_icon"><span class="ui-icon ui-icon-person"></span>Eingeloggt
                    als <?=$user->name . " " . $user->surname?></a></li>
                <li><a href="settings">Settings</a></li>
                <li><a href="logout">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="content-wr">

        <div id="header">

                <h1><a href="dashboard">Dashboard Admin</a></h1>
                <ul id="nav">
                    <li class="nav_icon <?if ($current_page == 'formular_create') echo 'nav_current' ?>">
                        <a href="formular/create">New formular</a>
                    </li>
                    <li class="nav_icon <?if ($current_page == 'formular_open') echo 'nav_current' ?>">
                        <a href="formular/open">Open formular</a>
                    </li>
                </ul>

        </div>

        <div id="masthead">
                <h1 class="no_breadcrumbs">
                    <?=$left_header?>
                    <span class="right-float"><?=$right_header?></span>
                </h1>
        </div>

        <div class="content xgrid">
            <?=$main_content?>
        </div>

    </div>
</div>
<div id="footer">
    <div class="content_pad">
        <p>&copy; 2010 - 2012 Copyright <a href="#">goUnique</a>. Powered by <a class="author-link"
                                                                            href="mailto:ozicoder@gmail.com">Vital
            Ozierski</a>.</p>
    </div>
</div>

</body>
</html>