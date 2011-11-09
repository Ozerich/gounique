<?php /* Smarty version Smarty-3.0.7, created on 2011-10-24 18:30:35
         compiled from "Z:\home\localhost\www\hotel\templates/dashboard.html" */ ?>
<?php /*%%SmartyHeaderCode:211334ea5849ba625d0-51752851%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68959585cc6de472a977ff35cbf8ae0f26b68fc3' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates/dashboard.html',
      1 => 1319470170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211334ea5849ba625d0-51752851',
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
    <script src="js/dashboard.js"></script>
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
            <li><a href="javascript:;" class="top_icon"><span class="ui-icon ui-icon-person"></span>Eingeloggt als Paul
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


<div class="content xgrid">
<form action="index.php" method="POST">
<div class="page" id="page1">
    <div class="input">
        <label for="agent_kunden">K/A</label>
        <select name="agent_kunden" id="agent_kunden">
            <option value="A">A</option>
            <option value="K">K</option>
        </select>
        <span class="hiddentext" id="agent_kunden_hid">agentur</span>
    </div>
    <div class="input" id="kundennummer-wr">
        <label for="kundennummer">Kundennumer:</label>
        <input type="text" noempty id="kundennummer" name="kundennummer" size="10"/>
        <span class="hiddentext" id="kundennummer_hid"></span>
    </div>
    <div class="input" id="vorgangsnummer-wr">
        <label for="vorgangsnummer">Vorgangsnummer:</label>
        <input type="text" noempty id="vorgangsnummer" name="vorgangsnummer" size="10"/>
        <span class="hiddentext" id="vorgangsnummer_hid"></span>
    </div>
    <div class="input" id="rechnungsnummber-wr">
        <label for="rechnungsnummber">Rechnungsnummer:</label>
        <input type="text" id="rechnungsnummber" name="rechnungsnummber" size="10"/>
        <span class="hiddentext" id="rechnungsnummber_hid"></span>
    </div>
    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input type="text" noempty numerical id="provision" name="provision" value="11" size="3" />
        <span class="hiddentext" id="provision_hid">11</span>
    </div>
    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" noempty numerical id="personcount" name="personcount" size="2"/>
        <span class="hiddentext" id="personcount_hid"></span>
    </div>
    <br class="clear"/>
</div>
<div class="page" id="hotels-page" style="display:none">
    <div class="hotels">
        <div class="hotel-wr" style="display:none">
            <div class="input">
                <label for="hotelcode">Hotel Code</label>
                <input type="text" name="hotelcode" size="8" id="hotelcode"/>
                <span id="hotelname"></span>
                <input type="hidden" id="hotelname_hid" />
            </div>
            <div class="input" id="roomcapacity-wr" style="display:none;">
                <label for="roomcapacity">Capacity</label>
                <select name="roomcapacity" id="roomcapacity"></select>
            </div>
            <div class="input" id="roomtype-wr" style="display:none;">
                <label for="roomtype">Room type</label>
                <select name="roomtype" id="roomtype"></select>
            </div>
            <div class="input" id="service-wr" style="display:none;">
                <label for="service">Service</label>
                <select name="service" id="service"></select>
            </div>
            <div class="input" id="date-wr" style="display:none;">
                <span>Date</span><br/>
                <label for="datestart">Von</label>
                <input type="text" name="datestart" class="datestart" value="29122011" size="10"/>
                <br class="clear"/>
                <label for="dateend">Bis&nbsp;</label>
                <input type="text" name="dateend" class="dateend" value="05012011" disabled size="10"/>
                <br class="clear"/>
                Days Count <input type="text" name="dayscount" class="dayscount" disabled value="0" size="3"/>
            </div>
            <div class="input" id="nohotel" style="display:none;">NOT FOUND</div>
            <div class="input" id="transfer-wr" style="display:none">
                <label for="transfer">Transfer</label>
                <select id="transfer" name="transfer">
                    <option value="no">KEIN TRANSFER</option>
                    <option value="in">TRANSFER IN</option>
                    <option value="out">TRANSFER OUT</option>
                    <option value="rt">TRANSFER RT</option>
                </select>
            </div>
            <div class="input" id="price-wr" style="display:none">
                <label for="price">Price</label>
                <input id="price" size="4" name="price"/>&nbsp;EUR
            </div>
            <br class="clear"/>

            <div class="input" id="remark-wr" style="display:none">
                <label for="remark">Remark</label>
                <input type="text" name="remark" id="remark" size="100"/>
            </div>
            <br class="clear"/>
        </div>
        <div class="manuel-wr" style="display:none">
            <div class="input" id="text-wr">
                <input type="text" size="100" name="text" id="text"/>
            </div>
            <div class="input" id="date-wr">
                <span>Date</span><br/>
                <label for="datestart">Von</label>
                <input type="text" name="manueldatestart" class="datestart" value="" size="10"/>
                <br class="clear"/>
                <label for="dateend">Bis&nbsp;</label>
                <input type="text" name="manueldateend" class="dateend" value="" disabled size="10"/>
                <br class="clear"/>
                Days Count <input type="text" name="manueldayscount" class="dayscount" disabled value="0" size="3"/>
            </div>
            <div class="input" id="price-wr">
                <label for="price">Price</label>
                <input id="price" size="4" name="manuelprice"/>&nbsp;EUR
            </div>
            <br class="clear"/>
        </div>
    </div>
    <div class="input" id="result-wr" style="display:none">
        <span name="result" id="result"></span>
    </div>
</div>

<div class="page" id="flugpage" style="display:none">
    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flight plan</label>
        <textarea id="flightplan" name="flightplan"></textarea>
    </div>
    <div class="input" id="flightprice-wr">
        <label for="flightprice">Preis of flight</label>
        <input type="text" id="flightprice" size="5" name="flightprice"/>
    </div>
    <br class="clear" />
</div>

<div class="page" id="buttons" style="display:none">
    <button class="btn btn-small btn-blue" id="addhotel-button">Add hotel</button>
    <button class="btn btn-small btn-blue" id="addmanuel-button">Add manuel</button>
    <button class="btn btn-small btn-blue" id="flug-button">Flug</button>
    <button class="btn btn-small btn-blue" id="fertig-button" name="fertig">Fertig</button>
</div>
</form>
</div>


</div>

<div id="footer">
    <div class="content_pad">
        <p>&copy; 2010-11 Copyright <a href="#">goUnique</a>. Powered by <a href="#">UniqueWorld.de</a>.</p>
    </div>
</div>
</body>

</html>