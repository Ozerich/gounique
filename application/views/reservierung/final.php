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
<div class="formular-header">
    <div class="left-block">
        <div class="param">
            <span class="param-name">Kundennummer:</span>
            <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
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

        <? if ($formular->status == "rechnung"): ?>
        <div class="param">
            <span class="param-name">Rechnungsnummer:</span>
            <span class="param-value"><?=$formular->r_num?></span>
        </div>
        <? endif; ?>

        <? if($formular->status == "rechnung" && $formular->is_storno): ?>
        <div class="param">
            <span class="param-name">Original Rechnung</span>
            <a class="param-value" href="reservierung/final/<?=$formular->storno_original?>"><?=$formular->original->r_num?></a>
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
        <input type="hidden" class="item_id" value="<?=$hotel->id?>"/>
        <input type="hidden" class="item_type" value="hotel"/>
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$hotel->plain_text . " - &nbsp;<b>" . $hotel->all_price . "&euro;</b>"; ?></span>
        <? if ($hotel->incoming): ?>
        <div class="incoming-sendblock">
            <a href="#" class="incoming-send">Send report</a>
            <span
                class="lastsend">Last send: <?=$hotel->incoming_sendtime ? $hotel->incoming_sendtime->format('d.m.Y H:i') : 'never'?></span>
        </div>
        <span class="incoming-sendok" style="display:none">OK</span>
        <? endif; ?>
    </div>
    <? endforeach; ?>

    <hr/>

    <span class="header">Manuell:</span>

    <? foreach ($formular->manuels as $ind => $manuel): ?>
    <div class="item">
        <input type="hidden" class="item_id" value="<?=$manuel->id?>"/>
        <input type="hidden" class="item_type" value="manuel"/>
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$manuel->plain_text; ?></span>
        <? if ($manuel->incoming): ?>
        <div class="incoming-sendblock">
            <a href="#" class="incoming-send">Send report</a>
            <span
                class="lastsend">Last send: <?=$manuel->incoming_sendtime ? $manuel->incoming_sendtime->format('d.m.Y H:i') : 'never'?></span>
        </div>
        <span class="incoming-sendok" style="display:none">OK</span>
        <? endif; ?>
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

        <div class="anzahlung-text">
            <? if ($formular->status == "rechnung"): ?>
            <? if ($formular->finalpayment_date): ?>
                <p>Anzahlung sofort nach Erhalt der Rechnung: <?=$formular->price['anzahlung_value']?> &euro;</p>
                <p>Restzahlung fällig am: <?=$formular->finalpayment_date->format('d-M-y')?>
                    &nbsp;&nbsp;<?=$formular->price['restzahlung']?> &euro;</p>
                <? else: ?>
                <p>Zahlung sofort nach Erhalt de Rechnung</p>
                <? endif; ?>
            <? endif; ?>
        </div>
    </div>
    <div class="right-float">
        <table class="price-table">
            <? if($formular->is_storno && $formular->status == "rechnung"): ?>
            <tr>
                <td class="param">Gesamptreisepreis</td>
                <td><?=$formular->original->price['brutto']?></td>
            </tr>
            <tr>
                <td class="param">Stornogebühr lt. AGB´s <?=$formular->original->storno_percent?>%</td>
                <td><?=$formular->original->price['storeno_brutto']?></td>
            </tr>
            <tr>
                <td class="param"><?=$formular->provision?>% Provision auf Storno</td>
                <td><?=$formular->original->price['storno_provision']?></td>
            </tr>
            <tr>
                <td class="param">19% MwSt.</td>
                <td><?=$formular->original->price['storno_mwst']?></td>
            </tr>
            <tr>
                <td class="param">Gesamptprovision</td>
                <td><?=$formular->original->price['storno_gesamtprovision']?></td>
            </tr>
            <? else: ?>
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
            <? if (!$formular->kunde->ausland): ?>
                <tr>
                    <td class="param">MWST auf Prov 19%</td>
                    <td><?=$formular->price['mwst']?></td>
                </tr>
                <? endif; ?>
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

            <? endif; ?>
            <? endif; ?>
        </table>


        <div class="price-buttons">
            <? if ($formular->status == "angebot"): ?>
            <a href="reservierung/eingangsmitteilung/<?=$formular->id?>" class="button-link">Als Eingangsmitteilung
                speichern</a>
            <? elseif ($formular->status == "eingangsmitteilung"): ?>

            <?=
            form_open("reservierung/do_rechnung/" . $formular->id)
            ; ?>
            <div class="anzahlung-block">
                <input type="hidden" value="<?=$formular->price['brutto']?>" name="brutto_price" id="brutto_price"/>

                <div class="param-block">
                    <label for="departure_date">Abreisedatum</label>
                    <input type="text" name="departure_date" size="8" maxlength="8"
                           value="<?=$formular->departure_date ? $formular->departure_date->format('m/d/Y') : ''?>"
                           id="departure_date"/>
                </div>

                <div class="prepayment-block" <? if (!$formular->finalpayment_date) echo 'style="display:none"' ?>>

                    <div class="param-block">
                        <label for="anzahlung" class="anzahlung">Anzahlung %</label>
                        <input type="text" name="prepayment" size="3" maxlength="3"
                               value="<?=$formular->prepayment ? $formular->prepayment : '25'?>"
                               id="anzahlung"/>
                        <span id="anzahlungsum">0</span> &euro;
                    </div>

                    <div class="param-block">
                        <label for="prepayment_date">Anzahlung Datum:</label>
                        <input type="text" name="preprepayment_date" size="8" maxlength="8"
                               value="<?=$formular->prepayment_date ? $formular->prepayment_date->format('m/d/Y') : ''?>"
                               id="prepayment_date"/>
                    </div>

                    <div class="param-block">
                        <label for="finalpayment_date">Restzahlung Datum:</label>
                        <input type="text" name="finalpayment_date" size="8" maxlength="8" id="finalpayment_date"
                               value="<?=$formular->finalpayment_date ? $formular->finalpayment_date->format('m/d/Y') : ''?>"/>
                    </div>
                </div>
            </div>

            <? if ($formular->can_rechnung): ?>
                <button>Als Rechnung speichern</button>
                <? else: ?>
                <a class="button-link disabled">Als Rechnung speichern</a>
                <?endif; ?>
            </form>

            <? elseif ($formular->status == "rechnung" && !$formular->is_storno): ?>
            <a href="reservierung/storeno/<?=$formular->id?>" class="button-link">Storno</a>
            <? endif; ?>
        </div>
    </div>
    <br class="clear"/>
</div>


<div id="stage">
    <? if (!$formular->is_storno): ?>

    <input type="radio" id="radio1" name="stage" value="1"
        <?if ($formular->status == "angebot" || $formular->status == "eingangsmitteilung") echo 'checked';?>/>
    <label for="radio1">Angebot</label>

    <? if ($formular->kunde->type == "agenturen"): ?>
        <input type="radio" id="radio2" name="stage"
               value="2"/><label for="radio2">Angebot
            (Kundenkopie)</label>
        <? endif; ?>

    <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <input type="radio" id="radio3" name="stage" value="3" checked/><label for="radio3">Rechnung</label>
        <? if ($formular->kunde->type == "agenturen"): ?>
            <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
                (Kundenkopie)</label>
            <? endif; ?>
        <? endif; ?>

    <? else: ?>
    <? if ($formular->kunde->type == "agenturen"): ?>
        <input type="radio" id="radio1" name="stage" checked value="5"/><label for="radio1">Storeno</label>
        <? endif; ?>
    <input type="radio" id="radio2" name="stage" value="6"/><label for="radio2">Storeno(Kundenkopie)</label>
    <? endif; ?>

</div>
<?=
form_open("reservierung/sendmail/" . $formular->id, null, array("formular_id" => $formular->id))
; ?>
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

    <div class="mail">
        <span class="left">Kunde E-Mail</span>
        <input type="text" size="30" class="email" value="<?=$formular->kunde->email?>"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>
</div>
</form>

<div id="final-buttons" class="formular-buttons">
    <? if (!$formular->is_storno): ?>
    <a href="reservierung/edit/<?=$formular->id?>" class="button-link">Formular editieren</a>
    <? endif; ?>
    <? if ($formular->status == "eingangsmitteilung" && !$formular->is_storno): ?>
    <a href="reservierung/status/<?=$formular->id?>" class="button-link">Status editieren</a>
    <? elseif ($formular->status == "rechnung" && !$formular->is_storno): ?>
    <a href="reservierung/payments/<?=$formular->id?>" class="button-link">Payments</a>
    <? endif; ?>
    <? if ($formular->status == "rechnung"  && !$formular->is_storno): ?>
    <a href="reservierung/vouchers/<?=$formular->id?>" class="button-link">Vouchers</a>
    <? endif; ?>
    <button id="addmail-button">E-Mail hinzufuegen</button>
    <a id="druck-link" href="#" class="button-link" target="_blank">Druck</a>
    <button id="send-button" name="submit">Senden</button>
    <a href="#" class="button-link">Schliessen</a>
</div>

</div>