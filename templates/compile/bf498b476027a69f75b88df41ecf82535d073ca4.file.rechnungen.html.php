<?php /* Smarty version Smarty 3.1.4, created on 2011-10-26 01:35:51
         compiled from "Z:\home\localhost\www\hotel\templates\email\rechnungen.html" */ ?>
<?php /*%%SmartyHeaderCode:247574ea739c769c455-58765265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf498b476027a69f75b88df41ecf82535d073ca4' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\hotel\\templates\\email\\rechnungen.html',
      1 => 1319580439,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '247574ea739c769c455-58765265',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'vorgansnummer' => 0,
    'today' => 0,
    'user' => 0,
    'persons' => 0,
    'ind' => 0,
    'person' => 0,
    'hotels' => 0,
    'hotel' => 0,
    'manuels' => 0,
    'manuel' => 0,
    'flugplan' => 0,
    'price' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ea739c77595e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ea739c77595e')) {function content_4ea739c77595e($_smarty_tpl) {?><div id="page">
    <div id="header"></div>
    <div id="content">
        <h1>REISEANGEBOT</h1>

        <div class="vorgansnummer-wr">
            <div class="left">
                <div class="header">Vorgansnummer</div>
                <div class="nummer"><?php echo $_smarty_tpl->tpl_vars['vorgansnummer']->value;?>
</div>
            </div>
            <div class="right">
                <div>Datum: <?php echo $_smarty_tpl->tpl_vars['today']->value;?>
</div>
                <div>Sachbearbeiter: <?php echo $_smarty_tpl->tpl_vars['user']->value['fullname'];?>
</div>
            </div>
        </div>
        <div class="mainblock">
            <div class="persons">
                <span class="header">Reiseteilnehmer:</span>
                <?php  $_smarty_tpl->tpl_vars['person'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['person']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['persons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['person']->key => $_smarty_tpl->tpl_vars['person']->value){
$_smarty_tpl->tpl_vars['person']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['person']->key;
?>
                <div class="person">
                    <div class="num"><?php echo $_smarty_tpl->tpl_vars['ind']->value+1;?>
</div>
                    <div class="sex"><?php echo $_smarty_tpl->tpl_vars['person']->value['sex'];?>
</div>
                    <div class="name"><?php echo $_smarty_tpl->tpl_vars['person']->value['name'];?>
</div>
                </div>
                <?php } ?>
                <br class="clear"/>
            </div>
            <div class="tours">
                <span class="header">Leistung:</span>
                <?php  $_smarty_tpl->tpl_vars['hotel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotel']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hotels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hotel']->key => $_smarty_tpl->tpl_vars['hotel']->value){
$_smarty_tpl->tpl_vars['hotel']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['hotel']->key;
?>
                <div class="tour">
                    <div class="date"> <?php echo $_smarty_tpl->tpl_vars['hotel']->value['datestart'];?>
 - <?php echo $_smarty_tpl->tpl_vars['hotel']->value['dateend'];?>
</div>
                    <div class="content"> <?php echo $_smarty_tpl->tpl_vars['hotel']->value['dayscount'];?>
N HOTEL: <?php echo $_smarty_tpl->tpl_vars['hotel']->value['hotelname'];?>
 /
                        <?php echo $_smarty_tpl->tpl_vars['hotel']->value['roomcapacity'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['roomtype'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['service'];?>
 / <?php echo $_smarty_tpl->tpl_vars['hotel']->value['transfer'];?>
 /
                        <?php echo $_smarty_tpl->tpl_vars['hotel']->value['remark'];?>

                    </div>
                </div>
                <?php } ?>
                <?php  $_smarty_tpl->tpl_vars['manuel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manuel']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['manuels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['manuel']->key => $_smarty_tpl->tpl_vars['manuel']->value){
$_smarty_tpl->tpl_vars['manuel']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['manuel']->key;
?>
                <div class="tour">
                    <div class="date"> <?php echo $_smarty_tpl->tpl_vars['manuel']->value['datestart'];?>
 - <?php echo $_smarty_tpl->tpl_vars['manuel']->value['dateend'];?>
</div>
                    <div class="content"> <?php echo $_smarty_tpl->tpl_vars['manuel']->value['text'];?>
</div>
                </div>
                <?php } ?>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['flugplan']->value!=''){?>
            <div class="flugplan">
                <span class="header">Flugplan:</span>
                <div class="content">
                    <pre><?php echo $_smarty_tpl->tpl_vars['flugplan']->value;?>
</pre>
                </div>
            </div>
            <?php }?>
            <div class="price-wr">
                Preis p.P:
                <span class="price"><?php echo $_smarty_tpl->tpl_vars['price']->value['person'];?>
-&euro;</span>
            </div>
        </div>
        <div class="priceblock">
            Gesamptreis: <span class="price"><?php echo $_smarty_tpl->tpl_vars['price']->value['netto'];?>
 &euro;</span>
        </div>
        <div class="bottomblock">
            <div class="signature">
                <span>Bei Buchungswunsch bitte unterschrieben zurückfaxen:</span>
                <div class="line"></div>
            </div>
            <p>Mit freundlichen Grüßen</p>

            <span>Paul Rawluschko<br/>Unique World GmbH</span>
        </div>
    </div>
    <div id="footer"></div>
</div><?php }} ?>