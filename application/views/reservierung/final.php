<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a
                href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a>
            </li>
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
            <span class="param-name">Kundennummer:</span>
            <a href="#"><?=$formular->kunde->k_num?></a>
        </div>

        <div class="param">
            <span class="param-name">Typ:</span>
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

        <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <div class="param">
            <span class="param-name">Rechnungsnummer:</span>
            <span class="param-value"><?=$formular->r_num?></span>
        </div>
        <? endif; ?>

    </div>
    <br class="clear"/>

</div>

<div class="persons-block">
    <h3 class="block-header">Reiseteilnehmer:</h3>

    <?if ($formular->persons)
    foreach ($formular->persons as $ind => $person):?>
        <div class="person-item">
            <span class="num"><?=($ind + 1);?></span>
            <span class="sex"><?=$person->sex?></span>
            <span class="name"><?=$person->name;?> / <?=$person->surname;?></span>
        </div>
        <? endforeach; ?>
</div>

<div class="item-list">
    <h3 class="block-header">Leistung:</h3>

    <span class="header">Hotels:</span>

    <? foreach ($formular->hotels as $ind => $hotel): ?>
    <div class="item">
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$hotel->plain_text . " - &nbsp;<b>" . $hotel->price . "&euro;</b>"; ?></span>
    </div>
    <? endforeach; ?>

    <hr/>

    <span class="header">Manuell:</span>

    <? foreach ($formular->manuels as $ind => $manuel): ?>
    <div class="item">
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$manuel->plain_text; ?></span>
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
            <h3 class="block-header">Kommentar:</h3>

            <p><?=$formular->comment;?></p>
        </div>


        <div class="address-block">
            <h3 class="block-header"><?=$formular->type == 'person' ? "Kundenadresse" : 'Agenturadresse'?></h3>

            <p><?=$formular->kunde->plain_text;?></p>
        </div>

        <div class="anzahlung-block">
            <p>Anzahlung sofort nach Erhalt die Rechnung: <?=$formular->price['anzahlung_value']?> &euro;</p>

            <? if ($formular->finalpayment_date): ?>
            <p>Restzahlung f&auml;llig am: <?=$formular->finalpayment_date->format('d-M-y')?>
                &nbsp;&nbsp;<?=($formular->price['brutto'] - $formular->price['anzahlung_value'])?> &euro;</p>
            <? endif; ?>
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
            <? if ($formular->status == 'rechnung'): ?>
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
            <a href="reservierung/eingangsmitteilung/<?=$formular->id?>" class="button-link">Als Eingangsmitteilung
                speichern</a>
            <? elseif ($formular->status == "eingangsmitteilung"): ?>
            <a <?if ($formular->can_rechnung) echo 'href="reservierung/rechnung/' . $formular->id . '"';?>
                class="button-link <?if (!$formular->can_rechnung) echo 'disabled'?>">Als Rechnung speichern</a>
            <? endif; ?>
        </div>
    </div>
    <br class="clear"/>
</div>


<? if ($formular->status != 'canceled'): ?>
<div id="stage">
    <input type="radio" id="radio1" name="stage"
           value="1" <?if ($formular->status == "angebot" || $formular->status == "eingangsmitteilung") echo 'checked';?>/><label
    for="radio1">Angebot</label>
    <? if ($formular->kunde->type == "agenturen"): ?>
    <input type="radio" id="radio2" name="stage"
           value="2"/><label for="radio2">Angebot
        (Kundenkopie)</label>
    <? endif; ?>
    <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
    <input type="radio" id="radio3" name="stage" value="3" checked/><label
        for="radio3">Rechnung</label>
    <? if ($formular->kunde->type == "agenturen"): ?>
        <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
            (Kundenkopie)</label>
        <? endif; ?>
    <? endif; ?>
</div>

<div class="mail-block">
    <div class="mail" style="display:none">
        <span class="left">Mail</span>
        <input type="text" size="30" class="email"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>
    <div class="mail">
        <span class="left">Administrator E-Mail</span>
        <input type="text" disabled size="30" class="email" value="<?=$user->email?>"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>

</div>

<div id="final-buttons" class="formular-buttons">
    <? if ($formular->status == "angebot"): ?>
    <a href="reservierung/edit/<?=$formular->id?>" class="button-link">Formular editieren</a>
    <? elseif ($formular->status == "eingangsmitteilung"): ?>
    <a href="reservierung/status/<?=$formular->id?>" class="button-link">Status editieren</a>
    <? elseif ($formular->status == "rechnung"): ?>
    <a href="reservierung/payments/<?=$formular->id?>" class="button-link">Payments</a>
    <? endif; ?>
    <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
    <a href="reservierung/vouchers/<?=$formular->id?>" class="button-link">Vouchers</a>
    <? endif; ?>
    <button id="addmail-button">E-Mail hinzufuegen</button>
    <a id="druck-link" href="#" class="button-link" target="_blank">Druck</a>
    <button id="send-button" name="submit">Senden</button>
    <a href="#" class="button-link">Schliessen</a>
</div>

    <? else: ?>
<div id="final-buttons">
    <a href="kunde/<?=$formular->kunde_id?>" id="close-button"
       name="submit">Schliessen</a>
</div>
    <? endif; ?>

</form>

</div>