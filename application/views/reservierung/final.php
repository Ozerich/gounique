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
<input type="hidden" id="formular_id" value="<?=$formular->id?>"/>

<div class="formular-header">
    <div class="left-block">
        <div class="param">
            <span class="param-name">Kundennummer:</span>
            <a id="kunde_link" for="<?=$formular->kunde->id?>" href="#"><?=$formular->kunde->k_num?></a>
            <? if (!$formular->is_storno && $formular->status != "storno"): ?>
            <a href="#" id="change-ag">Change</a>
            <input type="hidden" id="new_ag_id"/>
            <input type="hidden" id="new_ag_num"/>
            <a href="#" id="save-ag" style="display:none">Save</a>
            <input id="new_agnum" type="text" maxlength="20" size="20" style="display:none"/>
            <? endif; ?>
        </div>

        <div class="param">
            <span class="param-name">Typ:</span>
            <span class="param-value" id="formulartype-value"><?=$formular->type?></span>
        </div>

        <div class="param">
            <span class="param-name">Vorgangsnummer:</span>
            <a href="#" id="vorgangsnummer-value" class="param-value change-value"><?=$formular->v_num?></a>

            <div class="editparam" style="display: none">
                <input type="text" id="new_vnum_value" maxlength="6" value="<?=$formular->v_num?>"/>
                <a href="#" id="save-vnum" class="save_16"></a>
            </div>
        </div>

        <div class="param">
            <span class="param-name">Owner type:</span>
            <a href="#" id="ownertype-value" class="param-value change-value"><?=$formular->plain_ownertype?></a>

            <div class="editparam" style="display: none">
                <select id="new_ownertype_value">
                    <? foreach (Formular::$OWNER_TYPES as $ind => $type): ?>
                    <option <?=$formular->owner_type == $ind ? 'selected' : ''?> value="<?=$ind?>"><?=$type?></option>
                    <? endforeach; ?>
                </select>
                <a href="#" id="save-ownertype" class="save_16"></a>
            </div>
        </div>

    </div>

    <div class="right-block">

        <div class="param">
            <span class="param-name">Status:</span>
            <span class="param-value"><?=$formular->plain_status?></span>
        </div>

        <? if ($formular->status == "rechnung" || $formular->status == "storno" || $formular->status == "gutschrift"): ?>
        <div class="param">
            <span class="param-name"><?=$formular->is_storno ? "Original Rechnung:" : "Rechnungsnummer:"?></span>
            <span class="param-value"><?=$formular->r_num?></span>
        </div>
        <? endif; ?>

        <div class="param">
            <span class="param-name">Sachbearbeiter:</span>
            <span class="param-value"><?=$formular->sachbearbeiter->fullname?></span>
        </div>

        <? if ($formular->is_storno && $formular->status == "rechnung"): ?>
        <div class="param">
            <span class="param-name">Original Rechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->storno_original?>"><?=$formular->original->r_num?></a>
        </div>
        <div class="param">
            <span class="param-name">Gutschrift Rechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->gutschrift->id?>"><?=$formular->gutschrift->r_num?></a>
        </div>
        <? elseif ($formular->is_storno && $formular->status == "gutschrift"): ?>
        <div class="param">
            <span class="param-name">Original Rechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->storno_original?>"><?=$formular->original->r_num?></a>
        </div>
        <div class="param">
            <span class="param-name">Stornorechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->storno_rechnung->id?>"><?=$formular->storno_rechnung->r_num?></a>
        </div>

        <? elseif ($formular->is_storno && $formular->status == "storno"): ?>
        <div class="param">
            <span class="param-name">Stornorechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->storno_rechnung->id?>"><?=$formular->storno_rechnung->r_num?></a>
        </div>
        <div class="param">
            <span class="param-name">Gutschrift Rechnung</span>
            <a class="param-value"
               href="reservierung/final/<?=$formular->gutschrift->id?>"><?=$formular->gutschrift->r_num?></a>
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
<? if ($formular->type != 'nurflug'): ?>
<div class="item-list">
    <h3 class="block-header">Leistung:</h3>
    <? foreach ($formular->hotels_and_manuels as $ind => $item): ?>
    <div class="item">
        <input type="hidden" class="item_id" value="<?=$item->id?>"/>
        <input type="hidden" class="item_type" value="<?=$item->type?>"/>
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$item->plain_text . " - &nbsp;<b>" . $item->all_price . "&euro;</b>"; ?></span>
        <? if ($item->incoming): ?>
        <div class="incoming-sendblock">
            <a href="#" class="incoming-send">Send report</a>
                    <span
                            class="lastsend">Last send: <?=$item->incoming_sendtime ? $item->incoming_sendtime->format('d.m.Y H:i') : 'never'?></span>
        </div>
        <span class="incoming-sendok" style="display:none">OK</span>
        <? endif; ?>
    </div>
    <? endforeach; ?>
</div>
    <? endif; ?>

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

            <p><?=str_replace("\n", "<br/>", $formular->comment)?></p>
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
            <? if ($formular->status == "gutschrift"): ?>
            <tr>
                <td class="param">Gesamptreisepreis</td>
                <td><?=$formular->original->price['brutto']?></td>
            </tr>
            <tr class="underline">
                <td class="param">Gutschrift</td>
                <td>-<?=$formular->original->price['brutto']?></td>
            </tr>
            <tr class="up underline">
                <td class="param">Endpreise Netto</td>
                <td>0.00</td>
            </tr>
            <? elseif ($formular->is_storno && $formular->status == "rechnung"): ?>
            <tr>
                <td class="param">Gesamptreisepreis</td>
                <td><?=$formular->original->price['brutto']?></td>
            </tr>
            <tr class="underline up">
                <td class="param">Stornogebühr
                    <?=$formular->original->storno_percent ? 'lt. AGB´s ' . $formular->original->storno_percent . '%' : ''?></td>
                <td><?=num($formular->brutto, 2, ',', '.')?></td>
            </tr>
            <? if ($formular->kunde->type == "agenturen"): ?>
                <tr>
                    <td class="param"><?=$formular->provision?>% Provision auf Storno</td>
                    <td><?=$formular->price['provision']?></td>
                </tr>
                <tr>
                    <td class="param">19% MwSt.</td>
                    <td><?=$formular->price['mwst']?></td>
                </tr>
                <tr class="underline">
                    <td class="param">Gesamptprovision</td>
                    <td><?=number_format($formular->provision_amount, 2, ',', '.')?></td>
                </tr>
                <tr class="up underline">
                    <td class="param">Endpreise Netto</td>
                    <td><?=$formular->price['netto']?></td>
                </tr>
                <? endif; ?>
            <? else: ?>
            <tr>
                <td class="param">Preis Brutto/p.Person</td>
                <td><?=$formular->price['person']?></td>
            </tr>
            <tr class="underline up">
                <td class="param">Gesamtpreis</td>
                <td><?=$formular->price['brutto']?></td>
            </tr>
            <? if ($formular->kunde->type == 'agenturen' && $formular->type != 'nurflug'): ?>
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
                    <td><?=number_format($formular->provision_amount, 2, ',', '.')?></td>
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

        <? if ($formular->is_storno && $formular->status == 'storno'): ?>
            <div id="storno_manual">
                <div class="param">
                    <label for="storno_manual_date">Storno datum:</label>
                    <span><?=$formular->storno_date->format('d.m.Y');?></span>
                    <input type="text" name="date" id="storno_manual_date" value="<?=$formular->storno_date->format('dmY');?>"/>
                </div>

                <div class="param">
                    <label for="storno_manual_percent">Storno %:</label>
                    <span><?=$formular->storno_percent?></span>
                    <input type="text" name="percent" id="storno_manual_percent" value="<?=$formular->storno_percent;?>"/>
                </div>

                <div class="param">
                    <label for="storno_betrag">Storno Betrag:</label>
                    <span><?=$formular->storno_amount;?></span>
                    <input type="text" name="betrag" id="storno_betrag" value="<?=$formular->storno_amount;?>"/>
                </div>

                <div class="param">
                    <label>Storno by:</label>
                    <span><?=$formular->storno_user->fullname.' '.$formular->storno_date->format('d.m.Y')?></span>
                </div>

                <button id="storno_edit_open">Edit</button>
                <button id="storno_save" style="display:none">Save</button>
                <button id="storno_close" style="display:none">Close</button>
            </div>
        <? endif; ?>


        <div class="price-buttons">
            <? if ($formular->status == "angebot"): ?>
            <a href="reservierung/eingangsmitteilung/<?=$formular->id?>" class="button-link">Als Eingangsmitteilung
                speichern</a>
            <? elseif ($formular->status == "eingangsmitteilung"): ?>

            <?=
            form_open("reservierung/do_rechnung/" . $formular->id)
            ; ?>
            <div class="anzahlung-block">
                <input type="hidden" value="<?=$formular->brutto?>" name="brutto_price" id="brutto_price"/>

                <div class="param-block">
                    <label for="departure_date">Abreisedatum</label>
                    <input type="text" name="departure_date" size="8" maxlength="8"
                           value="<?=$formular->departure_date ? $formular->departure_date->format('mdY') : ''?>"
                           id="departure_date"/>
                </div>

                <div class="param-block">
                    <label for="finalpayment_date">Restzahlung Datum:</label>
                    <input type="text" name="finalpayment_date" size="8" maxlength="8" id="finalpayment_date"
                           value="<?=$formular->finalpayment_date ? $formular->finalpayment_date->format('mdY') : ''?>"/>
                </div>

                <div class="param-block">
                    <label for="sofort">Sofort</label>
                    <input type="checkbox" name="sofort" id="sofort"/>
                </div>

                <div class="prepayment-block">

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
                               value="<?=$formular->prepayment_date ? $formular->prepayment_date->format('mdY') : ''?>"
                               id="prepayment_date"/>
                    </div>


                </div>
            </div>

            <? if ($formular->can_rechnung): ?>
                <button id="do_rechnung">Als Rechnung speichern</button>
                <? else: ?>
                <a class="button-link disabled">Als Rechnung speichern</a>
                <?endif; ?>
            </form>

            <? elseif ($formular->status == "rechnung" && !$formular->is_storno && $this->user->id != 9): ?>
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
    <input type="radio" id="radio2" name="stage"
           value="2"/><label for="radio2">Angebot
        (Kundenkopie)</label>
    <? endif; ?>
    <? if (($formular->status == "rechnung" && !$formular->is_storno) || $formular->status == "storno"): ?>
    <input type="radio" id="radio3" name="stage" value="3" checked/><label for="radio3">Rechnung</label>
    <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
        (Kundenkopie)</label>
    <? elseif ($formular->status == "rechnung") : ?>
    <? if ($formular->kunde->type == "agenturen"): ?>
        <input type="radio" id="radio1" name="stage" checked value="5"/><label for="radio1">Storno</label>
        <? endif; ?>
    <input type="radio" id="radio2" name="stage" checked value="6"/><label for="radio2">Storno(Kundenkopie)</label>
    <? elseif ($formular->status == "gutschrift"): ?>
    <input type="radio" id="radio1" name="stage" checked value="7"/><label for="radio1">Gutscrift</label>
    <? endif; ?>


</div>
<?=
form_open("reservierung/sendmail/" . $formular->id, null, array("formular_id" => $formular->id))
;
?>
<? if ($this->user->id != 9): ?>
<div class="mail-block">
    <div class="mail" style="display:none">
        <span class="left">Mail</span>
        <input type="text" size="30" class="email"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>
    <div class="mail">
        <span class="left">Administrator E-Mail</span>
        <input type="text" disabled size="30" class="email" value="<?= $user->email ?>"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>

    <div class="mail">
        <span class="left">Kunde E-Mail</span>
        <input type="text" size="30" class="email" value="<?= $formular->kunde->email ?>"/>
        <span class="status">noch nicht gesendet</span>
        <input type="hidden" class="sended" value="0"/>
    </div>
</div>
    <? endif; ?>
</form>

<div id="final-buttons" class="formular-buttons">
    <? if ($this->user->id == 9): ?>
    <a id="druck-link" href="#" class="button-link" target="_blank">Druck</a>
    <? else: ?>
    <? if($formular->is_storno == 0): ?><a href="reservierung/edit/<?= $formular->id ?>" class="button-link">Formular editieren</a><? endif;?>
    <? if ($formular->status == "eingangsmitteilung" && !$formular->is_storno): ?>
        <a href="reservierung/status/<?= $formular->id ?>" class="button-link">Status editieren</a>
        <? endif; ?>
    <? if ($formular->status == "rechnung" && !$formular->is_storno): ?>
        <a href="reservierung/vouchers/<?= $formular->id ?>" class="button-link">Vouchers</a>
        <? endif; ?>
    <button id="addmail-button">E-Mail hinzufuegen</button>
    <a id="druck-link" href="#" class="button-link" target="_blank">Druck</a>
    <button id="send-button" name="submit">Senden</button>
    <a href="#" class="button-link">Schliessen</a>

    <? endif; ?>
</div>
</div>