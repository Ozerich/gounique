<?php /* Smarty version Smarty-3.0.7, created on 2011-10-24 12:51:55
         compiled from "Z:\home\localhost\www\hotel\templates/result.html" */ ?>
<?php /*%%SmartyHeaderCode:92894ea5353b503096-82073789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '985eba2286c220944784fe10d3681ea98cacbfca' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates/result.html',
      1 => 1319449912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92894ea5353b503096-82073789',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Dashboard | Dashboard Admin</title>

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
    <script src="js/result.js"></script>
    <script src="js/misc/excanvas.min.js"></script>
    <script src="js/jquery/facebox.js"></script>
    <script src="js/jquery/jquery.visualize.js"></script>
    <script src="js/jquery/jquery.dataTables.min.js"></script>
    <script src="js/jquery/jquery.tablesorter.min.js"></script>
    <script src="js/jquery/jquery.uniform.min.js"></script>
    <script src="js/jquery/jquery.placeholder.min.js"></script>
    <script src="js/widgets.js"></script>

    <link rel="stylesheet" href="css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" media="screen"
          title="no title"/>
    <link rel="stylesheet" href="css/plugin/jquery.visualize.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/facebox.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/uniform.default.css" type="text/css" media="screen" title="no title"/>
    <link rel="stylesheet" href="css/plugin/dataTables.css" type="text/css" media="screen" title="no title"/>

    <link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" title="no title">

</head>

<body>

<div id="wrapper">

    <div id="top">
        <div class="content_pad">
            <ul class="right">
                <li><a href="javascript:;" class="top_icon"><span class="ui-icon ui-icon-person"></span>Eingeloggt als
                    Paul
                    Rawluschko</a></li>
                <!--	<li><a href="javascript:;" class="new_messages top_alert">1 New Message</a></li>-->
                <li><a href="./pages/settings.html">Settings</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
    </div>


    <div id="header">
        <div class="content_pad">
            <h1><a href="index.php">Dashboard Admin</a></h1>
            <ul id="nav">
                <li class="nav_current nav_icon"><a href="./dashboard.html">Angebot</a></li>
                <li class="nav_icon"><a href="#">Eingangsmitteilungen</a></li>
                <li class="nav_icon"><a href="#">Rechnungen</a></li>
            </ul>
        </div>
    </div>


    <div id="masthead">
        <div class="content_pad">
            <h1 class="no_breadcrumbs">Reisengebot Formular</h1>
        </div>
    </div>

    <div class="page" id="resultpage">
        <div id="resultcontent">
            <div id="results-wr">
                <span class="number">1</span>

                <div id="results">
                    <?php  $_smarty_tpl->tpl_vars['hotel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hotels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hotel']->key => $_smarty_tpl->tpl_vars['hotel']->value){
?>
                    <?php echo $_smarty_tpl->tpl_vars['hotel']->value['datestart'];?>
 - <?php echo $_smarty_tpl->tpl_vars['hotel']->value['dateend'];?>
 <?php echo $_smarty_tpl->tpl_vars['hotel']->value['dayscount'];?>
N HOTEL: <?php echo $_smarty_tpl->tpl_vars['hotel']->value['hotelname'];?>
 /
                    <?php echo $_smarty_tpl->tpl_vars['hotel']->value['roomcapacity'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['roomtype'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['service'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['transfer'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['remark'];?>

                    <br/>
                    <?php }} ?>
                    <?php  $_smarty_tpl->tpl_vars['manuel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('manuels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['manuel']->key => $_smarty_tpl->tpl_vars['manuel']->value){
?>
                    <?php echo $_smarty_tpl->tpl_vars['manuel']->value['datestart'];?>
 - <?php echo $_smarty_tpl->tpl_vars['manuel']->value['dateend'];?>
 <?php echo $_smarty_tpl->tpl_vars['manuel']->value['text'];?>

                    <br/>
                    <?php }} ?>
                </div>
            </div>
            <div id="flightplan-wr">
                <span class="number">2</span>
                <span>Flightplan</span>&nbsp;<b><?php echo $_smarty_tpl->getVariable('flightplan')->value['price'];?>
&euro;</b><br/><br/>
                <pre class="flightplan"><?php echo $_smarty_tpl->getVariable('flightplan')->value['content'];?>
</pre>

            </div>
            <div id="priceresult">
                <input type="hidden" name="priceperson"/>
                <span class="price_title">Preis p.P brutto:</span><span id="oneprice"><?php echo $_smarty_tpl->getVariable('price')->value['person'];?>
</span> &euro;<br/>
                <span class="price_title">Gesamtpreis brutto:</span><span id="gesamtpreis"><?php echo $_smarty_tpl->getVariable('price')->value['brutto'];?>
</span> &euro;<br/>
                <span class="price_title">Provision:</span><span id="provision"><?php echo $_smarty_tpl->getVariable('price')->value['provision'];?>
</span> &euro;<br/>
                <span class="price_title">19 % Mwst:</span><span id="percent"><?php echo $_smarty_tpl->getVariable('price')->value['percent'];?>
</span> &euro;<br/><br/>
                <span class="price_title">Gesamtpreis netto:</span><span id="netto"><?php echo $_smarty_tpl->getVariable('price')->value['netto'];?>
</span> &euro;<br/>
            </div>
            <br class="clear"/>

            <div class="mail-wr">
                <div class="mail" style="display:none">
                    <span>Mail</span>
                    <input type="text" size="30" class="email"/>
                    <span class="good" style="display:none;">OK</span>
                </div>
            </div>
        </div>
        <div id="result-buttons">
            <button class="btn btn-small btn-blue" id="edit-button">Edit formular</button>
            <button class="btn btn-small btn-blue" id="next-button">Next</button>
        </div>
    </div>


    <div id="footer">
        <div class="content_pad">
            <p>&copy; 2010-11 Copyright <a href="#">goUnique</a>. Powered by <a href="#">UniqueWorld.de</a>.</p>
        </div>
    </div>
</body>

</html>