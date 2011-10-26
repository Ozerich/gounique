<?php /* Smarty version Smarty 3.1.4, created on 2011-10-26 01:33:26
         compiled from "Z:\home\localhost\www\hotel\templates\final.html" */ ?>
<?php /*%%SmartyHeaderCode:173794ea6be678956c2-71508434%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbd5b7d85fe670822e6f34ebb598c6dbf70a788c' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates\\final.html',
      1 => 1319559821,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173794ea6be678956c2-71508434',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ea6be67a1941',
  'variables' => 
  array (
    'id' => 0,
    'hotels' => 0,
    'hotel' => 0,
    'manuels' => 0,
    'manuel' => 0,
    'flightplan' => 0,
    'price' => 0,
    'bigcomment' => 0,
    'persons' => 0,
    'ind' => 0,
    'person' => 0,
    'type' => 0,
    'address' => 0,
    'anzahlung' => 0,
    'abreisedatum' => 0,
    'stage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ea6be67a1941')) {function content_4ea6be67a1941($_smarty_tpl) {?><!DOCTYPE html>

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
    <script src="js/final.js"></script>
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
                <li><a href="logout.php">Logout</a></li>
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

    <form action="index.php?step=finish&vorgan=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" method="POST">
        <div class="page" id="resultpage">
            <div id="resultcontent">
                <div id="results-wr">
                    <span class="number">1</span>

                    <div id="results">
                        <?php  $_smarty_tpl->tpl_vars['hotel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotel']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hotels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hotel']->key => $_smarty_tpl->tpl_vars['hotel']->value){
$_smarty_tpl->tpl_vars['hotel']->_loop = true;
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
 /
                        <?php echo $_smarty_tpl->tpl_vars['hotel']->value['remark'];?>

                        <br/>
                        <?php } ?>
                        <?php if ($_smarty_tpl->tpl_vars['manuels']->value){?>

                        <?php  $_smarty_tpl->tpl_vars['manuel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manuel']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manuels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['manuel']->key => $_smarty_tpl->tpl_vars['manuel']->value){
$_smarty_tpl->tpl_vars['manuel']->_loop = true;
?>
                        <?php echo $_smarty_tpl->tpl_vars['manuel']->value['datestart'];?>
 - <?php echo $_smarty_tpl->tpl_vars['manuel']->value['dateend'];?>
 <?php echo $_smarty_tpl->tpl_vars['manuel']->value['text'];?>

                        <br/>
                        <?php } ?>
                        <?php }?>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['flightplan']->value['content']!=''){?>
                <div id="flightplan-wr">
                    <span class="number">2</span>
                    <span>Flightplan</span>&nbsp;<b><?php echo $_smarty_tpl->tpl_vars['flightplan']->value['price'];?>
&euro;</b><br/><br/>
                    <pre class="flightplan"><?php echo $_smarty_tpl->tpl_vars['flightplan']->value['content'];?>
</pre>
                </div>
                <?php }?>
                <div id="priceresult">
                    <input type="hidden" name="priceperson"/>
                    <span class="price_title">Preis p.P brutto:</span><span
                        id="oneprice"><?php echo $_smarty_tpl->tpl_vars['price']->value['person'];?>
</span> &euro;<br/>
                    <span class="price_title">Gesamtpreis brutto:</span><span
                        id="gesamtpreis"><?php echo $_smarty_tpl->tpl_vars['price']->value['brutto'];?>
</span> &euro;<br/>
                    <span class="price_title">Provision:</span><span
                        id="provision"><?php echo $_smarty_tpl->tpl_vars['price']->value['provision'];?>
</span> &euro;<br/>
                    <span class="price_title">19 % Mwst:</span><span
                        id="percent"><?php echo $_smarty_tpl->tpl_vars['price']->value['percent'];?>
</span> &euro;<br/><br/>
                    <span class="price_title">Gesamtpreis netto:</span><span
                        id="netto"><?php echo $_smarty_tpl->tpl_vars['price']->value['netto'];?>
</span> &euro;<br/>
                </div>
                <br class="clear"/>

                <div class="comment-wr">
                    <h3>Comment</h3>

                    <p><?php echo $_smarty_tpl->tpl_vars['bigcomment']->value;?>
</p>
                </div>
                <div id="persons-wr">
                    <h3>Persons:</h3>
                    <?php  $_smarty_tpl->tpl_vars['person'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['person']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['persons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['person']->key => $_smarty_tpl->tpl_vars['person']->value){
$_smarty_tpl->tpl_vars['person']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['person']->key;
?>
                    <?php echo $_smarty_tpl->tpl_vars['ind']->value+1;?>
 - <?php echo $_smarty_tpl->tpl_vars['person']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['person']->value['sex'];?>
)<br/>
                    <?php } ?>
                    <br/><br/>
                </div>

                <div id="address-wr">
                    <h3><?php if ($_smarty_tpl->tpl_vars['type']->value=='K'){?>Kundenadresse<?php }else{ ?>Agenturadresse<?php }?></h3>

                    <p><?php echo $_smarty_tpl->tpl_vars['address']->value;?>
</p>
                </div>
                <div id="anzahlung-wr">
                    <span>Anzahlung: <?php echo $_smarty_tpl->tpl_vars['anzahlung']->value;?>
 %</span>
                </div>
                <div id="abreisedatum-wr">
                    <span>Abreisedatum: <?php echo $_smarty_tpl->tpl_vars['abreisedatum']->value;?>
</span>
                </div>

                <div id="stage-wr">
                    <label for="stage">Stage</label>
                    <div id="stage">
                        <input type="radio" id="radio1" name="radio" value="1" <?php if ($_smarty_tpl->tpl_vars['stage']->value==1){?>checked="checked"<?php }?>/><label for="radio1">Angebot</label>
                        <input type="radio" id="radio2" name="radio" value="2" <?php if ($_smarty_tpl->tpl_vars['stage']->value==2){?>checked="checked"<?php }?>/><label for="radio2">Eingangsmitteilungen</label>
                        <input type="radio" id="radio3" name="radio" value="3" <?php if ($_smarty_tpl->tpl_vars['stage']->value==3){?>checked="checked"<?php }?>/><label for="radio3">Rechnungen</label>
                    </div>
                </div>

                <div class="mail-wr">
                    <div class="mail" style="display:none">
                        <span>Mail</span>
                        <input type="text" size="30" class="email"/>
                        <span class="good" style="display:none;">OK</span>
                    </div>
                </div>
            </div>
            <input type="hidden" id="vorgan" name="vorgan" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"/>

            <div id="final-buttons">
                <button class="btn btn-small btn-blue" id="edit-button">Edit Formular</button>
                <button class="btn btn-small btn-blue" id="addmail-button">Add mail</button>
                <button class="btn btn-small btn-blue" id="druck-button">Druck</button>
                <button class="btn btn-small btn-blue" id="close-button" name="submit">Send & Close</button>
            </div>
        </div>
    </form>


    <div id="footer">
        <div class="content_pad">
            <p>&copy; 2010-11 Copyright <a href="#">goUnique</a>. Powered by <a href="#">UniqueWorld.de</a>.</p>
        </div>
    </div>
</body>

</html><?php }} ?>