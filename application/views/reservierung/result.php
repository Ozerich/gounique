<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a></li>
             </li>
            <li><span>formular <?=$formular->v_num?></span></li>
        </ul>
    </div>
</div>

<div id="result-page" class="reservierung-page result-page content">
<?=form_open("reservierung/result/" . $formular->id);?>
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

        <? if($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <div class="param">
            <span class="param-name">Rechnungsnummer:</span>
            <span class="param-value"><?=$formular->r_num?></span>
        </div>
        <? endif; ?>

    </div>
    <br class="clear"/>

</div>
<div class="item-list">
    <h3 class="block-header">Leistung:</h3>

    <span class="header">Hotels:</span>

    <? foreach ($formular->hotels as $ind => $hotel): ?>
    <div class="item">
        <span class="num"><?=($ind + 1)?></span>
        <span class="text"><?=$hotel->plain_text." - &nbsp;<b>" . $hotel->all_price . "&euro;</b>"; ?></span>
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
                                <option value="herr" <? if ($person->sex == 'herr') echo 'selected'; ?>>Herr</option>
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


        <div class="anzahlung-block">

            <div class="param-block">
                <label for="anzahlung">Anzahlung %</label>
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
                <label for="departure_date">Abreisedatum</label>
                <input type="text" name="departure_date" size="8" maxlength="8"
                       value="<?=$formular->departure_date ? $formular->departure_date->format('m/d/Y') : ''?>"
                       id="departure_date"/>
            </div>
            <div class="param-block">
                <label for="finalpayment_date">Restzahlung Datum:</label>
                <input type="text" name="finalpayment_date" size="8" maxlength="8" id="finalpayment_date"
                       value="<?=$formular->finalpayment_date ? $formular->finalpayment_date->format('m/d/Y') : ''?>"/>

            </div>
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
            <tr class="up">
                <td class="param">Endpreise Netto</td>
                <td><?=$formular->price['netto']?></td>
            </tr>
            <? endif; ?>
        </table>
    </div>
    <br class="clear"/>
</div>

<div class="comment-block">
    <h3 class="block-header">Kommentar:</h3>
    <textarea id="comment" name="bigcomment"><?=$formular->comment?></textarea>
</div>


<div id="result-buttons" class="formular-buttons">
    <a href="reservierung/edit/<?=$formular->id?>" class="button-link">Zur&uuml;ck</a>
    <button name="submit">Speichern</button>
</div>
</div>
</form>
</div>