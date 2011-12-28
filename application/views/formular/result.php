<div id="result-page">
    <? echo form_open("formular/result/" . $formular->id, '', array("vorgan" => $formular->v_num, "paymentdate" => $formular->payment_date,
    "formular_id" => $formular->id)); ?>
    <div class="page" id="resultpage">
        <div id="resultcontent">
            <div id="results-wr">
                <span class="number">1</span>

                <div id="results">
                    <?
                    if ($hotels)
                        foreach ($hotels as $hotel)
                        {
                            echo $hotel->date_start . " - " . $hotel->date_end . " " . $hotel->days_count . "N HOTEL: " .
                                $hotel->hotel_name . " / " . RoomCapacity::find_by_id($hotel->roomcapacity_id)->value . " / " .
                                RoomType::find_by_id($hotel->roomtype_id)->value . " / " . HotelService::find_by_id($hotel->hotelservice_id)->value .
                                " / TRANSFER " . strtoupper($hotel->transfer) . " / " . $hotel->remark . " - &nbsp;<b>" . $hotel->price . "&euro;</b><br/>";
                        }
                    if (!empty($manuels))
                        foreach ($manuels as $manuel)
                            echo $manuel->date_start . " - " . $manuel->date_end . " " . $manuel->text . " - &nbsp;<b>" . $manuel->price . "&euro;</b><br/>";
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
                <label for="comment">Comment</label>
                <textarea id="comment" name="bigcomment" style="width:100%"><?=$formular->comment?></textarea>
            </div>
            <div id="persons-wr">
                <? $persons = FormularPerson::find('all', array('conditions' => array('formular_id = ?', $formular->id)));

                if ($persons)
                    foreach ($persons as $ind => $person):?>
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
                <? for ($i = count($persons); $i < $formular->person_count; $i++): ?>
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


            <div id="anzahlung-wr">
                <label for="anzahlung">Anzahlung</label>
                <input type="text" name="prepayment" size="3" maxlength="3" value="<?=$formular->prepayment?>"
                       id="anzahlung"/>% -
                <span id="anzahlungsum">0</span> &euro;
            </div>
            <div id="abreisedatum-wr">
                <label for="abreisedatum">Abreisedatum</label>
                <input type="text" name="prepayment_date" size="8" maxlength="8" value="<?=$formular->payment_date?>"
                       id="abreisedatum"/>
            </div>

        </div>

        <div id="result-buttons">
            <button class="btn btn-small btn-blue" id="back-button">Back</button>
            <button class="btn btn-small btn-blue" id="next-button" name="submit">Save</button>
        </div>
    </div>
    </form>
</div>