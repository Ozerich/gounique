<div id="final-page" class="result-page">
    <?=form_open("formular/sendmail/" . $formular->id, null, array("formular_id" => $formular->id)); ?>
    <div class="info-block">
        <div class="left-info">
            <span class="param">Vorgangsnummer: </span><span
            class="value vorgan_value"><?=$formular->v_num?></span><br/>
            <span class="param">Rechnungsnummer: </span><span
            class="value"><?=($formular->r_num) ? $formular->r_num : "none";?></span><br/>
            <span class="param">Abreisedatum: </span><span
            class="value"><?=$formular->payment_date->format('d.m.Y')?></span><br/>
        </div>

        <div class="right-info">
            <span class="param">Datum: </span><span class="value"><?=mdate("%d.%m.%Y", time());?></span><br/>
            <span class="param">Sachbearbeiter: </span><span
            class="value"><?=$user->name . " " . $user->surname?></span><br/>
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
        </div>
        <? endforeach; ?>

        <hr/>

        <span class="header">Manuels:</span>

        <? foreach ($formular->manuels as $ind => $manuel): ?>
        <div class="item">
            <span class="num"><?=($ind + 1)?></span>
            <span class="text"><?=$manuel->plain_text; ?></span>
        </div>
        <? endforeach; ?>
    </div>

    <div class="flight-block">
        <h3 class="block-header">Flugplan: <span class="flight-price"><?=$formular->flight_price?> &euro;</span>
        </h3>

        <p>
        <pre><?=$formular->flight_text?></pre>
        </p>
    </div>

    <div class="bottom-block">
        <div class="left">
            <div class="comment-block">
                <h3 class="block-header">Comment:</h3>

                <p><?=$formular->comment;?></p>
            </div>


            <div class="address-block">
                <h3 class="block-header"><?=$formular->type == 'person' ? "Kundenadresse" : 'Agenturadresse'?></h3>

                <p><?=$formular->agency->plain_text;?></p>
            </div>

            <div class="anzahlung-block">
                <p>Anzahlung sofort nach Erhalt de Rechnung: <?=$formular->price['anzahlung_value']?> &euro;</p>

                <p>Restzahlung fallig am: <?=$formular->payment_date->format('d-M-y')?>
                    &nbsp;&nbsp;<?=($formular->price['brutto'] - $formular->price['anzahlung_value'])?> &euro;</p>
            </div>
        </div>

        <table class="price-table">
            <tr>
                <td class="param">Preis Brutto/p.Person</td>
                <td><?=$formular->price['person']?></td>
            </tr>
            <tr class="underline up">
                <td class="param">Gesamtpreis</td>
                <td><?=$formular->price['brutto']?></td>
            </tr>
            <? if ($formular->agency->type == 'agency'): ?>
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
        <br class="clear"/>
    </div>


    <? if (!$formular->canceled): ?>
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
            <span>Mail</span>
            <input type="text" size="30" class="email"/>
            <span class="good" style="display:none;">OK</span>
        </div>
    </div>

    <div id="final-buttons">
        <? if ($formular->r_num == 0): ?>
        <a href="formular/edit/<?=$formular->id?>" class="btn btn-small btn-blue">Edit Formular</a>
        <? else: ?>
        <a href="formular/status/<?=$formular->id?>" class="btn btn-small btn-blue">Edit Statuses</a>
        <? endif; ?>
        <button class="btn btn-small btn-blue" id="addmail-button">Add mail</button>
        <button class="btn btn-small btn-blue" id="druck-button">Druck</button>
        <button class="btn btn-small btn-blue" id="sendclose-button" name="submit">Send & Close</button>
        <? if ($formular->r_num == 0): ?>
        <button class="btn btn-small btn-blue" id="makerechnung-button">Make Rechnung</button>
        <? else: ?>
        <button class="btn btn-small btn-red" id="makestoreno-button">Storno</button>
        <? endif; ?>
    </div>

    <? else: ?>
    <div id="final-buttons">
        <a href="agency/<?=$formular->agency_id?>" class="btn btn-small btn-blue" id="close-button"
           name="submit">Close</a>
    </div>
    <? endif; ?>

    </form>

</div>