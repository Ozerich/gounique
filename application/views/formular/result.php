<div id="result-page">
    <? echo form_open("formular/result/" . $formular->v_num, '', array("vorgan" => $formular->v_num, "zahlungsdatum" => $formular->zahlungsdatum)); ?>
    <div class="page" id="resultpage">
        <div id="resultcontent">
            <div id="results-wr">
                <span class="number">1</span>

                <div id="results">
                    <?if($formular->hotel_list) {

                    foreach ($formular->hotel_list as $hotel)
                    {
                        echo $hotel['date_start'] . " - " . $hotel['date_end']  . " " . $hotel['days_count']  . "N HOTEL: " . $hotel['name']  .
                             " / " . $hotel['room_capacity']  . " / " . $hotel['room_type']  . " / " . $hotel['room_service']  . " / TRANSFER " .
                             $hotel['transfer']  . " / " . $hotel['remark']  . " - &nbsp;<b>" . $hotel['price']  . "&euro;</b><br/>";
                    }
                }
                    if (!empty($manuels))
                        foreach ($manuels as $manuel)
                            echo $manuel['date_start'] . " - " . $manuel['date_end'] . " " . $manuel['text'] . " - &nbsp;<b>" . $manuel['price'] . "&euro;</b><br/>";
                    ?>
                </div>
            </div>
            <? if($formular->flight_plan != ""): ?>
            <div id="flightplan-wr">
                <span class="number">2</span>
                <span>Flightplan</span>&nbsp;<b><?=$formular->flight_price?>&euro;</b><br/><br/>
                <pre class="flightplan"><?=$formular->flight_plan?></pre>
            </div>
            <? endif; ?>
            <div id="priceresult">
                <input type="hidden" name="priceperson"/>
                <span class="price_title">Preis p.P brutto:</span><span
                    id="oneprice"><?=$price['person']?></span> &euro;<br/>
                <span class="price_title">Gesamtpreis brutto:</span><span
                    id="gesamtpreis"><?=$price['brutto']?></span> &euro;<br/>
                <span class="price_title">Provision:</span><span
                    id="provision"><?=$price['provision']?></span> &euro;<br/>
                <span class="price_title">19 % Mwst:</span><span
                    id="percent"><?=$price['percent']?></span> &euro;<br/><br/>
                <span class="price_title">Gesamtpreis netto:</span><span
                    id="netto"><?=$price['netto']?></span> &euro;<br/>
            </div>
            <br class="clear"/>

            <div class="comment-wr">
                <label for="comment">Comment</label>
                <textarea id="comment" name="bigcomment" style="width:100%"><?=$formular->comment?></textarea>
            </div>
            <div id="persons-wr">
                <? for ($i = 1; $i <= $formular->personcount; $i++): ?>
                <div class="person">
                    <span class="num"><?=$i?></span>

                    <div class="input">
                        <label for="sex">Herr/Frau</label>
                        <select name="sex[<?=$i?>]" id="sex">
                            <option value="Herr"
                                <?if (isset($formular->person_list[$i - 1]) && $formular->person_list[$i - 1]['sex'] == 'Herr') echo 'selected';?>>
                                Herr
                            </option>
                            <option value="Frau"
                                <?if (isset($formular->person_list[$i - 1]) && $formular->person_list[$i - 1]['sex'] == 'Frau') echo 'selected';?>>
                                Frau
                            </option>
                            <option value="Kind"
                                <?if (isset($formular->person_list[$i - 1]) && $formular->person_list[$i - 1]['sex'] == 'Kind') echo 'selected';?>>
                                Kind
                            </option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Nachname/Vorname</label>
                        <input type="text" name="person_name[<?=$i?>]" id="person_name"
                               value="<?if (isset($formular->person_list[$i - 1])) echo $formular->person_list[$i - 1]['name'];?>" size="20"/>
                    </div>
                    <br class="clear"/>
                </div>
                <? endfor; ?>
            </div>


            <div id="anzahlung-wr">
                <label for="anzahlung">Anzahlung</label>
                <input type="text" name="anzahlung" size="3" maxlength="3" value="<?=$formular->anzahlung?>"
                       id="anzahlung"/>% - <span
                    id="anzahlungsum">0</span> &euro;
            </div>
            <div id="abreisedatum-wr">
                <label for="abreisedatum">Abreisedatum</label>
                <input type="text" name="abreisedatum" size="8" maxlength="8" value="<?=$formular->abreisedatum?>"
                       id="abreisedatum"/>
            </div>

        </div>
        <input type="hidden" name="vorgan" id="vorgan" value="<?=$formular->v_num?>" />
        <div id="result-buttons">
            <button class="btn btn-small btn-blue" id="back-button">Back</button>
            <button class="btn btn-small btn-blue" id="next-button" name="submit">Save</button>
        </div>
    </div>
    </form>
</div>