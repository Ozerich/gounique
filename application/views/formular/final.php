<div id="final-page">
    <? form_open("formular/finish/" . $formular->v_num); ?>
    <div class="page" id="resultpage">
        <div id="resultcontent">
            <div id="topinfo" class="block">
                <div class="left-float">
                    <span class="param">Vorgangsnummer: </span><span class="value vorgan_value"><?=$formular->v_num?></span><br/>
                    <span class="param">Abreisedatum: </span><span
                        class="value"><?=$formular->abreisedatum?></span><br/>
                </div>
                <div class="right-float">
                    <span class="param">Datum: </span><span class="value">TODAY</span><br/>
                    <span class="param">Sachbearbeiter: </span><span
                        class="value"><?=$user->name . " " . $user->surname?></span><br/>
                </div>
                <br class="clear"/>
            </div>
            <div id="results">
                <?if ($formular->hotel_list) {

                foreach ($formular->hotel_list as $hotel)
                {
                    echo $hotel['date_start'] . " - " . $hotel['date_end'] . " " . $hotel['days_count'] . "N HOTEL: " . $hotel['name'] .
                         " / " . $hotel['room_capacity'] . " / " . $hotel['room_type'] . " / " . $hotel['room_service'] . " / TRANSFER " .
                         $hotel['transfer'] . " / " . $hotel['remark'] . " - &nbsp;<b>" . $hotel['price'] . "&euro;</b><br/>";
                }
            }
                if (!empty($manuels))
                    foreach ($manuels as $manuel)
                        echo $manuel['date_start'] . " - " . $manuel['date_end'] . " " . $manuel['text'] . " - &nbsp;<b>" . $manuel['price'] . "&euro;</b><br/>";
                ?>
            </div>
        </div>
        <? if ($formular->flight_plan != ""): ?>
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
            <h3>Comment</h3>

            <p><?=$formular->comment?></p>
        </div>
        <div id="persons-wr">
            <h3>Persons:</h3>
            <? foreach ($formular->person_list as $ind => $person)
            echo ($ind + 1) . " - " . $person['name'] . " (" . $person['sex'] . ")<br/>";
            ?>
            <br/><br/>
        </div>

        <div id="address-wr">
            <h3><? echo $formular->type == 'K' ? "Kundenadresse" : "Agenturadresse"?></h3>

            <p>
                <?
                echo ($formular->agency->type == 'agency')
                        ? $formular->agency->name . "<br />" . $formular->agency->address . "<br/>" . $formular->agency->plz .
                          " " . $formular->agency->ort :
                        $formular->agency->address . "<br/>" . $formular->agency->plz . " " . $formular->agency->ort;
                ?>
            </p>
        </div>
        <div id="anzahlung-wr">

        </div>

        <div id="stage-wr">
            <label for="stage" class="stage-header">Stage</label>

            <div id="stage">
                <input type="radio" id="radio1" name="stage"
                       value="1" <?if ($formular->stage == 1) echo 'checked';?>/><label for="radio1">Angebot</label>
                <input type="radio" id="radio2" name="stage"
                       value="2" <?if ($formular->stage == 2) echo 'checked';?>/><label for="radio2">Angebot
                (Kundenkopie)</label>
                <? if ($formular->stage == 2): ?>
                <input type="radio" id="radio3" name="stage" value="3"/><label for="radio3">Rechnung</label>
                <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
                    (Kundenkopie)</label>
                <? endif; ?>
            </div>
            <? if ($formular->stage != 2): ?>
            <button class="btn btn-small btn-blue" id="makerechnung-button">Make Rechnung</button>
            <? endif; ?>
            <br class="clear"/>
        </div>

        <div class="mail-wr">
            <div class="mail" style="display:none">
                <span>Mail</span>
                <input type="text" size="30" class="email"/>
                <span class="good" style="display:none;">OK</span>
            </div>

        </div>
    </div>

    <div id="final-buttons">
        <? if ($formular->stage == 1): ?>
        <button class="btn btn-small btn-blue" id="edit-button">Edit Formular</button>
        <? endif; ?>
        <button class="btn btn-small btn-blue" id="addmail-button">Add mail</button>
        <button class="btn btn-small btn-blue" id="druck-button">Druck</button>
        <button class="btn btn-small btn-blue" id="close-button" name="submit">Send & Close</button>
    </div>
</div>
</form>

</div>