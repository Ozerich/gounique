<div id="final-page">
    <?= form_open("formular/sendmail/" . $formular->id, null, array("formular_id" => $formular->id))
    ; ?>

<div class="page" id="resultpage">
    <div id="resultcontent">
        <div id="topinfo" class="block">
            <div class="left-float">
                <span class="param">Vorgangsnummer: </span><span
                class="value vorgan_value"><?=$formular->v_num?></span><br/>
                <? if ($formular->r_num): ?>
                <span class="param">Rechnungsnummer: </span><span class="value"><?=$formular->r_num?></span><br/>
                <? endif ?>
                <span class="param">Abreisedatum: </span><span
                class="value"><?=$formular->payment_date->format('d.m.Y')?></span><br/>
            </div>
            <div class="right-float">
                <span class="param">Datum: </span><span class="value"><?=mdate("%d.%m.%Y", time());?></span><br/>
                <span class="param">Sachbearbeiter: </span><span
                class="value"><?=$user->name . " " . $user->surname?></span><br/>
            </div>
            <br class="clear"/>
        </div>
        <div id="results">
            <?
            if ($hotels)
                foreach ($hotels as $hotel)
                {
                    echo $hotel->date_start->format('d.m.Y') . " - " . $hotel->date_end->format('d.m.Y') . " " . $hotel->days_count . "N HOTEL: " .
                        $hotel->hotel_name . " / " . RoomCapacity::find_by_id($hotel->roomcapacity_id)->value . " / " .
                        RoomType::find_by_id($hotel->roomtype_id)->value . " / " . HotelService::find_by_id($hotel->hotelservice_id)->value .
                        " / TRANSFER " . strtoupper($hotel->transfer) . " / " . $hotel->remark . " - &nbsp;<b>" . $hotel->price . "&euro;</b><br/>";
                }
            if (!empty($manuels))
                foreach ($manuels as $manuel)
                    echo $manuel->date_start->format('d.m.Y') . " - " . $manuel->date_end->format('d.m.Y') . " " . $manuel->text . " - &nbsp;<b>" . $manuel->price . "&euro;</b><br/>";
            ?>
        </div>
    </div>
    <? if ($formular->flight_text != ""): ?>
    <div id="flightplan-wr">
        <span class="number">2</span>
        <span>Flightplan</span>&nbsp;<b><?=$formular->flight_price?>&euro;</b><br/><br/>
        <pre class="flightplan"><?=$formular->flight_text?></pre>
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
        <? $persons = FormularPerson::find('all', array('conditions' => array('formular_id = ?', $formular->id)));
        if ($persons)
            foreach ($persons as $ind => $person)
                echo ($ind + 1) . " - " . $person->person_name . " (" . FormularPerson::$sex_map[$person->sex] . ")<br/>";
        ?>
        <br/><br/>
    </div>

    <div id="address-wr">
        <h3><? echo $formular->type == 'person' ? "Kundenadresse" : "Agenturadresse"?></h3>

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

    <? if (!$formular->canceled): ?>
    <div id="stage-wr">
        <label for="stage" class="stage-header">Stage</label>

        <div id="stage">
            <input type="radio" id="radio1" name="stage"
                   value="1" <?if ($formular->r_num == 0) echo 'checked';?>/><label for="radio1">Angebot</label>
            <input type="radio" id="radio2" name="stage"
                   value="2"/><label for="radio2">Angebot
            (Kundenkopie)</label>
            <? if ($formular->r_num): ?>
            <input type="radio" id="radio3" name="stage" value="3" <?if ($formular->r_num) echo 'checked';?>/><label
                for="radio3">Rechnung</label>
            <input type="radio" id="radio4" name="stage" value="4"/><label for="radio4">Rechnung
                (Kundenkopie)</label>
            <? endif; ?>
        </div>
        <? if ($formular->r_num == 0): ?>
        <button class="btn btn-small btn-blue" id="makerechnung-button">Make Rechnung</button>
        <? else: ?>
        <button class="btn btn-small btn-red" id="makestoreno-button">Storno</button>
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
        <? if ($formular->r_num == 0): ?>
        <button class="btn btn-small btn-blue" id="edit-button">Edit Formular</button>
        <? endif; ?>
        <button class="btn btn-small btn-blue" id="addmail-button">Add mail</button>
        <button class="btn btn-small btn-blue" id="druck-button">Druck</button>
        <button class="btn btn-small btn-blue" id="sendclose-button" name="submit">Send & Close</button>
    </div>
    <? else: ?>
    <div id="final-buttons">
        <a href="agency/<?=$formular->agency_id?>" class="btn btn-small btn-blue" id="close-button" name="submit">Close</a>
    </div>
    <? endif; ?>
    </form>

</div>