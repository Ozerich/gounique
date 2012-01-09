<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></span></li>
            </li>
            <li><span>formular <?=$formular->v_num?></span></li>
        </ul>
    </div>
</div>

<div id="final-page" class="reservierung-page result-page content">
<?=form_open("reservierung/sendmail/" . $formular->id, null, array("formular_id" => $formular->id)); ?>
<div class="formular-header">
    <div class="left-block">
        <div class="param">
            <span class="param-name">Kundensnummer:</span>
            <a href="#"><?=$formular->kunde->k_num?></a>
        </div>

        <div class="param">
            <span class="param-name">Type:</span>
            <span class="param-value" id="formulartype-value"><?=$formular->type?></span>
        </div>

        <div class="param">
            <span class="param-name">Vorgangsnummer:</span>
            <span class="param-value" id="vorgangsnummer-value"><?=$formular->v_num?></span>
        </div>

    </div>

    <div class="right-block">

        <div class="param">
            <span class="param-name">Status:</span>
            <span class="param-value"><?=$formular->plain_status?></span>
        </div>

    </div>
    <br class="clear"/>

</div>

<div class="persons-block">
    <h3 class="block-header">Reiseteilnehmer:</h3>

    <?if ($formular->persons)
    foreach ($formular->persons as $ind => $person):?>
        <div class="person-item">
            <span class="num"><?=($ind + 1);?></span>
            <span class="sex"><?=FormularPerson::$sex_map[$person->sex];?></span>
                <span class="name"><?=$person->person_name;?>
        </div>
        <? endforeach; ?>
</div>

<div class="item-list">
    <h3 class="block-header">Leistung:</h3>

    <span class="header">Hotels:</span>

    <? foreach ($formular->hotels as $ind => $hotel): ?>
    <div class="item">
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$hotel->plain_text; ?></span>
        <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <a href="pdf/<?=$hotel->voucher_name?>" target="_blank" class="voucher-button">Voucher</a>
        <? endif ?>
    </div>
    <? endforeach; ?>

    <hr/>

    <span class="header">Manuels:</span>

    <? foreach ($formular->manuels as $ind => $manuel): ?>
    <div class="item">
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$manuel->plain_text; ?></span>
        <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <a href="pdf/<?=$manuel->voucher_name?>" class="voucher-button" target="_blank">Voucher</a>
        <? endif ?>
    </div>
    <? endforeach; ?>

    <hr/>
</div>

<div class="flight-block">
    <h3 class="block-header">Flugplan: <span class="flight-price"><?=$formular->flight_price?> &euro;</span>
    </h3>

    <p>
    <pre><?=$formular->flight_text?></pre>
    </p>
</div>

<div class="bottom-block">
    <div class="left-float">
        <div class="comment-block">
            <h3 class="block-header">Comment:</h3>

            <p><?=$formular->comment;?></p>
        </div>


        <div class="address-block">
            <h3 class="block-header"><?=$formular->type == 'person' ? "Kundenadresse" : 'Agenturadresse'?></h3>

            <p><?=$formular->kunde->plain_text;?></p>
        </div>

        <div class="anzahlung-block">
            <p>Anzahlung sofort nach Erhalt de Rechnung: <?=$formular->price['anzahlung_value']?> &euro;</p>

            <p>Restzahlung fallig am: <?=$formular->finalpayment_date->format('d-M-y')?>
                &nbsp;&nbsp;<?=($formular->price['brutto'] - $formular->price['anzahlung_value'])?> &euro;</p>
        </div>
    </div>
    <div class="right-float">
        <table class="price-table">
            <tr>
                <td class="param">Preis Brutto/p.Person</td>
                <td><?=$formular->price['person']?></td>
            </tr>
            <tr class="underline up">
                <td class="param">Gesamtpreis</td>
                <td><?=$formular->price['brutto']?></td>
            </tr>
            <? if ($formular->kunde->type == 'agenturen'): ?>
            <tr>
                <td class="param">Provision <?=$formular->provision?>%</td>
                <td><?=$formular->price['provision']?></td>
            </tr>
            <tr>
                <td class="param">MWST auf Prov 19%</td>
                <td><?=$formular->price['mwst']?></td>
            </tr>
            <tr>
                <td class="param">Total Provision:</td>
                <td><?=$formular->price['total_provision']?></td>
            </tr>
            <tr class="empty">
                <td class="param">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="up underline">
                <td class="param">Endpreise Netto</td>
                <td><?=$formular->price['netto']?></td>
            </tr>
            <? if ($formular->status != 'angebot'): ?>
                <tr>
                    <td class="param">Paid</td>
                    <td><?=$formular->paid_amount?></td>
                </tr>
                <tr>
                    <td class="param">Need to paid</td>
                    <td><?=($formular->price['brutto'] - $formular->paid_amount)?></td>
                </tr>
                <? endif; ?>
            <? endif; ?>
        </table>
        <div class="price-buttons">
            <? if ($formular->status == "angebot"): ?>
            <a href="reservierung/eingangsmitteilung/<?=$formular->id?>" class="button-link">Make Eingangsmitteilung</a>
            <? elseif ($formular->status == "eingangsmitteilung"): ?>
        <a <?if ($formular->can_rechnung) echo 'href="reservierung/rechnung/'.$formular->id.'"';?> class="button-link <?if (!$formular->can_rechnung) echo 'disabled'?>">Make rechnung</a>
        <? elseif ($formular->status == "rechnung"): ?>
            <a href="reservierung/storeno/<?=$formular->id?>" class="button-link red">Storno</a>
            <? endif; ?>
        </div>
    </div>
    <br class="clear"/>
</div>


<? if ($formular->status != 'canceled'): ?>
<div id="stage">
    <input type="radio" id="radio1" name="stage"
           value="1" <?if ($formular->r_num == 0) echo 'checked';?>/><label for="radio1">Angebot</label>
    <input type="radio" id="radio2" name="stage"
           value="2"/><label for="radio2">Angebot
    (Kundenkopie)</label>
    <? if ($formular->r_num): ?>
    <input type="radio" id="radio3" name="stage" value="3" checked/><label
            for="radio3">Rechnung</label>
    <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
        (Kundenkopie)</label>
    <? endif; ?>
</div>

<div class="mail-block">
    <div class="mail" style="display:none">
        <span class="left">Mail</span>
        <input type="text" size="30" class="email"/>
        <span class="status">not send</span>
        <input type="hidden" class="sended" value="0"/>
    </div>
    <div class="mail">
        <span class="left">admin mail</span>
        <input type="text" disabled size="30" class="email" value="<?=$user->email?>"/>
        <span class="status">not send</span>
        <input type="hidden" class="sended" value="0"/>
    </div>

</div>

<div id="final-buttons" class="formular-buttons">
    <? if ($formular->status == "angebot"): ?>
    <a href="reservierung/edit/<?=$formular->id?>" class="button-link">Edit Formular</a>
    <? elseif ($formular->status == "eingangsmitteilung"): ?>
    <a href="reservierung/status/<?=$formular->id?>" class="button-link">Edit Statuses</a>
    <? elseif ($formular->status == "rechnung"): ?>
    <a href="reservierung/payments/<?=$formular->id?>" class="button-link">Payments</a>
    <? endif; ?>
    <button id="addmail-button">Add mail</button>
    <button id="druck-button">Druck</button>
    <button id="send-button" name="submit">Send</button>
    <a href="#" class="button-link">Close</a>
</div>

    <? else: ?>
<div id="final-buttons">
    <a href="kunde/<?=$formular->kunde_id?>" id="close-button"
       name="submit">Close</a>
</div>
    <? endif; ?>

</form>

</div>