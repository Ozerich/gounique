<div id="result-page" class="result-page">
    <? echo form_open("formular/result/" . $formular->id, '', array("vorgan" => $formular->v_num, "paymentdate" => $formular->prepayment_date,
    "formular_id" => $formular->id)); ?>
    <div class="info-block">
        <div class="left-info">

            <span class="param">Vorgangsnummer: </span><span
            class="value vorgan_value"><?=$formular->v_num?></span><br/>

            <? if($formular->r_num): ?>
            <span class="param">Rechnungsnummer: </span><span
            class="value"><?=($formular->r_num) ? $formular->r_num : "none";?></span><br/>
            <? endif; ?>

            <? if ($formular->prepayment_date): ?>
            <span class="param">Abreisedatum: </span><span
                class="value"><?=$formular->prepayment_date->format('d.m.Y')?></span><br/>
            <? endif; ?>

        </div>

        <div class="right-info">
            <span class="param">Datum: </span><span class="value"><?=mdate("%d.%m.%Y", time());?></span><br/>
            <span class="param">Sachbearbeiter: </span><span
            class="value"><?=$user->name . " " . $user->surname?></span><br/>
        </div>

        <br class="clear"/>
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
        <div class="left">
            <div id="persons-wr">
                <?
                if ($formular->persons)
                    foreach ($formular->persons as $ind => $person):?>
                        <div class="person">
                            <span class="num"><?=($ind + 1)?></span>

                            <div class="input">
                                <label for="sex">Herr/Frau</label>
                                <select name="person_sex[<?=$ind?>]" id="sex">
                                    <option value="man" <? if ($person->sex == 'man') echo 'selected'; ?>>Herr</option>
                                    <option value="woman" <? if ($person->sex == 'woman') echo 'selected'; ?>>Frau
                                    </option>
                                    <option value="child" <? if ($person->sex == 'child') echo 'selected'; ?>>Kind
                                    </option>
                                    <option
                                        value="child_less_2" <? if ($person->sex == 'child_less_2') echo 'selected'; ?>>
                                        Kind < 2
                                    </option>
                                </select>
                            </div>
                            <div class="input">
                                <label>Nachname/Vorname</label>
                                <input type="text" name="person_name[<?=$ind?>]" id="person_name"
                                       value="<?=$person->person_name?>" size="20"/>
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
                            <option value="man">Herr</option>
                            <option value="woman">Frau</option>
                            <option value="child">Kind</option>
                            <option value="child_less_2">Kind < 2</option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Nachname/Vorname</label>
                        <input type="text" name="person_name[<?=$i?>]" id="person_name" value="" size="20"/>
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
                    <label for="prepayment_date">Anzahlung datum:</label>
                    <input type="text" name="preprepayment_date" size="8" maxlength="8"
                           value="<?=$formular->prepayment_date ? $formular->prepayment_date->format('dmY') : ''?>"
                           id="prepayment_date"/>
                </div>
                <div class="param-block">
                    <label for="departure_date">Abreisedatum</label>
                    <input type="text" name="departure_date" size="8" maxlength="8"
                           value="<?=$formular->departure_date ? $formular->departure_date->format('dmY') : ''?>"
                           id="departure_date"/>
                </div>
                <div class="param-block">
                    <label for="finalpayment_date">Restzahlung datum:</label>
                    <input type="text" name="finalpayment_date" size="8" maxlength="8" id="finalpayment_date"
                           value="<?=$formular->finalpayment_date ? $formular->finalpayment_date : ''?>"/>

                </div>
            </div>
        </div>

        <table class="price-table">
            <tr>
                <td class="param">Preis Brutto/p.Person</td>
                <td><?=$formular->price['person']?></td>
            </tr>
            <tr class="underline up">
                <td class="param">Gesamtpreis</td>
                <td id="brutto-value"><?=$formular->price['brutto']?></td>
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

    <div class="comment-block">
        <h3 class="block-header">Comment:</h3>
        <textarea id="comment" name="bigcomment"><?=$formular->comment?></textarea>
    </div>


    <div id="result-buttons">
        <button class="btn btn-small btn-blue" id="back-button">Back</button>
        <button class="btn btn-small btn-blue" id="next-button" name="submit">Save</button>
    </div>
</div>
</form>
</div>