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

<div id="result-page" class="reservierung-page result-page content">
<input type="hidden" id="formular_id" value="<?=$formular->id?>"/>
<?if ($formular->status == 'rechnung'): ?>
<div id="rechnung-alert" class="alert-block">
    <p>Diese rehnung, 30 € wert Bearbeitung! Tun Sie das nicht!</p>
</div>
    <? endif;?>
<?=form_open("reservierung/result/" . $formular->id);?>
<div class="formular-header">
    <div class="left-block">
        <div class="param">
            <span class="param-name">Kundennummer:</span>
            <a id="kunde_link" for="<?=$formular->kunde->id?>" href="#"><?=$formular->kunde->k_num?></a>
            <a href="#" id="change-ag">Change</a>
            <input type="hidden" id="new_ag_id"/>
            <input type="hidden" id="new_ag_num"/>
            <a href="#" id="save-ag" style="display:none">Save</a>
            <input id="new_agnum" type="text" maxlength="20" size="20" style="display:none"/>
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

        <div class="param">
            <span class="param-name">Sachbearbeiter:</span>
            <span class="param-value"><?=$formular->sachbearbeiter->fullname?></span>
        </div>

    </div>
    <br class="clear"/>

</div>
<div class="item-list">
    <? if ($formular->type != 'nurflug'): ?>
    <h3 class="block-header">Leistung:</h3>
    <? foreach ($formular->hotels_and_manuels as $ind => $item): ?>
        <div class="item">
            <span class="num"><?=($ind + 1)?></span>
            <span class="text"><?=$item->plain_text . " - &nbsp;<b>" . $item->all_price . "&euro;</b>"; ?></span>
        </div>
        <? endforeach; ?>
    <? endif; ?>
</div>

<? if ($formular->flight_text != ""): ?>
<div class="flight-block">
    <h3 class="block-header">Flugplan: <span class="flight-price"><?=$formular->flight_price?> &euro;</span>
    </h3>

    <p>
    <pre><?=$formular->flight_text?></pre>
    </p>
</div>
    <? endif; ?>
<div class="bottom-block">
    <div class="left-float">
        <div id="persons-wr">
            <?
            if ($formular->persons)
                foreach ($formular->persons as $ind => $person):?>
                    <div class="person">
                        <span class="num"><?=($ind + 1)?></span>

                        <div class="input">
                            <label for="sex">Herr/Frau</label>
                            <select name="person_sex[<?=$ind?>]" id="sex">
                                <option value="herr" <? if ($person->sex == 'herr') echo 'selected'; ?>>Herr
                                </option>
                                <option value="frau" <? if ($person->sex == 'frau') echo 'selected'; ?>>Frau
                                </option>
                                <option value="child" <? if ($person->sex == 'child') echo 'selected'; ?>>Kind
                                </option>
                                <option
                                    value="infant" <? if ($person->sex == 'infant') echo 'selected'; ?>>
                                    Kind < 2
                                </option>
                            </select>
                        </div>
                        <div class="input">
                            <label>Nachname/Vorname</label>
                            <input type="text" name="person_name[<?=$ind?>]" class="person-name"
                                   value="<?=$person->name?>" size="20"/>
                            /
                            <input type="text" name="person_surname[<?=$ind?>]" class="person-name"
                                   value="<?=$person->surname?>" size="20"/>
                        </div>
                        <br class="clear"/>
                        <input type="hidden" name="person_id[<?=$ind?>]" value="<?=$person->id?>"/>
                    </div>
                    <? endforeach; ?>
            <? for ($i = count($formular->persons); $i < $formular->person_count; $i++): ?>
            <div class="person">
                <span class="num"><?=($i + 1)?></span>

                <div class="input">
                    <label for="sex">Herr/Frau</label>
                    <select name="person_sex[<?=$i?>]" id="sex">
                        <option value="herr">Herr</option>
                        <option value="frau">Frau</option>
                        <option value="child">Kind</option>
                        <option value="infant">Baby</option>
                    </select>
                </div>
                <div class="input">
                    <label>Nachname/Vorname</label>
                    <input type="text" name="person_name[<?=$i?>]" class="person-name" value="" size="20"/> /
                    <input type="text" name="person_surname[<?=$i?>]" class="person-name" value="" size="20"/>
                </div>
                <br class="clear"/>
            </div>
            <? endfor; ?>
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
                <td id="brutto-value"><?=$formular->price['brutto']?></td>
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
                <td><?=number_format($formular->provision_amount, 2, ',','.')?></td>
            </tr>
            <tr class="empty">
                <td class="param">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="up">
                <td class="param">Endpreise Netto</td>
                <td><?=$formular->price['netto']?></td>
            </tr>
            <? endif; ?>
        </table>
    </div>
    <br class="clear"/>
</div>
<div class="anzahlung-block">

    <div class="param-block">
        <label for="departure_date">Abreisedatum</label>
        <input type="text" name="departure_date" size="8" maxlength="8"
               value="<?=$formular->departure_date ? $formular->departure_date->format('m/d/Y') : ''?>"
               id="departure_date"/>
    </div>

    <div class="param-block">
        <label for="arrival_date">Rückreisedatum</label>
        <input type="text" name="arrival_date" size="8" maxlength="8"
               value="<?=$formular->arrival_date ? $formular->arrival_date->format('m/d/Y') : ''?>"
               id="arrival_date"/>
    </div>


    <div class="comment-block">
        <h3 class="block-header">Kommentar:</h3>
        <textarea id="comment" name="bigcomment"><?=$formular->comment?></textarea>
    </div>


    <div id="result-buttons" class="formular-buttons">
        <a href="reservierung/edit/<?=$formular->id?>" class="button-link">Zur&uuml;ck</a>
        <input type="submit" id="speichern" value="Speichern"/>
    </div>
</div>
</form>
</div>