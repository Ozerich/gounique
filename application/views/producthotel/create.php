<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>neueu hotel</span></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
<?=form_open("product/hotel/create")?>

<ul id="tabs">
    <li class="active"><span for="crs-page">CRS Daten</span></li>
    <li><span for="klassen-page">Childs & Extras</span></li>
    <li><span for="bonus-page">Bonuses</span></li>
    <li><span for="kontakt-page">Kontaktdaten</span></li>
</ul>

<div class="page" id="crs-page">
    <div class="param">
        <label for="code">Hotelcode</label>
        <input name="code" class="high-letters" type="text" id="code" maxlength="10"/>
    </div>

    <div class="param">
        <label for="name">Hotelname</label>
        <input name="name" type="text" id="name"/>
    </div>

    <div class="param">
        <label for="category">Kategorie</label>
        <input name="stars" type="text" id="category"/>
    </div>

    <div class="param">
        <label for="tlc">Hotel TLC</label>
        <input name="tlc" type="text" id="tlc"/>
    </div>

    <div class="param">
        <label for="zielgibiet">Zielgebiet</label>
        <input name="zielgibiet" type="text" id="zielgibiet"/>
    </div>

    <div class="param">
        <label for="ort">Hotel Ort</label>
        <input name="ort" type="text" id="ort"/>
    </div>

    <div class="param">
        <label for="land">Hotel Land</label>
        <input name="land" type="text" id="land"/>
    </div>

    <div class="param radios">
        <div class="left">
            <label for="flugbindung">Flugbindung</label>

            <div class="buttonset">
                <input type="radio" value="1" id="flug-on" name="flugbindung"/><label for="flug-on">On</label>
                <input type="radio" value="0" id="flug-off" name="flugbindung" checked/><label
                for="flug-off">Off</label>
            </div>
        </div>
        <div class="right">
            <label for="crs">CRS Status</label>

            <div class="buttonset">
                <input type="radio" value="1" id="crs-on" name="crs"/><label for="crs-on">On</label>
                <input type="radio" value="0" id="crs-off" name="crs" checked/><label for="crs-off">Off</label>
            </div>
        </div>
        <br class="clear"/>
    </div>
</div>

<div class="page" id="klassen-page" style="display: none">
    <div class="child-block">

        <div class="child-cat">
            <div class="child-preview">
                <span>Teen</span>
                <input type="checkbox" name="teenblock_active"/>
            </div>
            <div class="child-content">
                <table>
                    <thead>
                    <th class="active">&nbsp;</th>
                    <th class="age">von</th>
                    <th class="age">bis</th>
                    </thead>
                    <tbody>
                    <tr class="example">
                        <td class="active"><input type="checkbox" for-name="teen-active" checked></td>
                        <td class="age">
                            <input type="text" maxlength="2" value="12"/>
                            <input type="hidden" for-name="teen-von"/>
                        </td>
                        <td class="age">
                            <input type="text" maxlength="2" value="18"/>
                            <input type="hidden" for-name="teen-bis"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button class="child-new">New</button>
            </div>
        </div>
        <div class="child-cat">
            <div class="child-preview">
                <span>Kind / Child</span>
                <input type="checkbox" name="childblock_active"/>
            </div>
            <div class="child-content">
                <table>
                    <thead>
                    <th class="active">&nbsp;</th>
                    <th class="age">von</th>
                    <th class="age">bis</th>
                    </thead>
                    <tbody>
                    <tr class="example">
                        <td class="active"><input type="checkbox" for-name="child-active" checked></td>
                        <td class="age">
                            <input type="text" maxlength="2" value="2"/>
                            <input type="hidden" for-name="child-von"/>
                        </td>
                        <td class="age">
                            <input type="text" maxlength="2" value="12"/>
                            <input type="hidden" for-name="child-bis"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button class="child-new">New</button>
            </div>
        </div>
        <div class="child-cat">
            <div class="child-preview">
                <span>Baby / Infant</span>
                <input type="checkbox" name="infantblock_active"/>
            </div>
            <div class="child-content">
                <table>
                    <thead>
                    <th class="active">&nbsp;</th>
                    <th class="age">von</th>
                    <th class="age">bis</th>
                    </thead>
                    <tbody>
                    <tr class="example">
                        <td class="active"><input type="checkbox" for-name="infant-active" checked></td>
                        <td class="age">
                            <input type="text" maxlength="2" value="0"/>
                            <input type="hidden" for-name="infant-von"/>
                        </td>
                        <td class="age">
                            <input type="text" maxlength="2" value="2"/>
                            <input type="hidden" for-name="infant-bis"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button class="child-new">New</button>
            </div>
        </div>


        <br class="clear"/>
    </div>
    <div class="minimum-block">
        <span class="block-header">Minimums:</span>

        <div class="minimum-list">
            <span class="empty">No minumum</span>

            <div class="minimum-item example" style="display:none">

                <div class="period-param param">
                    <label for="von">Period von</label>
                    <input type="text" class="minimum-von" maxlength="8"/>
                    <label for="bis">bis</label>
                    <input type="text" class="minimum-bis" maxlength="8"/>
                    <a href="#" class="delete-icon minimum-delete"></a>
                </div>
                <div class="period-param param">
                    <label for="nachte_max">Nachte:</label>
                    <input type="text" id="nachte_max" class="minimum-nights"/>
                </div>

            </div>
        </div>
        <button id="new-minimum">Neueu minimum</button>
        <br class="clear"/>
    </div>
    <div class="holiday-block">
        <div class="param">
            <div class="left">
                <label for="xmas_dinner">X-Mas Dinner &euro;</label>
                <input name="xmas_dinner" type="text" value="0" id="xmas_dinner"/>
            </div>
            <div class="right">
                <label for="newyear_dinner">New Year Dinner &euro;</label>
                <input type="text" name="newyear_dinner" value="0" id="newyear_dinner"/>
            </div>
            <br class="clear"/>
        </div>

    </div>
    <div class="extras-block">
        <div class="param">
            <label for="kontityp">Konti. Typ</label>
            <select name="kontityp" id="kontityp">
                <option value="0">Tageskontingent</option>
                <option value="1">Basispreis</option>
            </select>
        </div>
        <div class="param">
            <label for="incoming">Agentur Bin.</label>
            <select name="incoming" id="incoming">
                <? foreach (Kunde::find('all', array('conditions' => array("type = 'incoming'"))) as $kunde): ?>
                <option value="<?=$kunde->id?>"><?=$kunde->k_num . " " . $kunde->name?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="param radios">
            <div class="left">
                <label for="optionsbuchung">Optionsbuchung</label>

                <div class="buttonset">
                    <input type="radio" value="1" id="optionsbuchung-on" name="optionsbuchung"/><label
                    for="optionsbuchung-on">On</label>
                    <input type="radio" value="0" id="optionsbuchung-off" name="optionsbuchung" checked/><label
                    for="optionsbuchung-off">Off</label>
                </div>
            </div>
            <div class="right">
                <label for="rq_buchung">RQ Buchung</label>

                <div class="buttonset">
                    <input type="radio" value="1" id="rq_buchung-on" name="rq_buchung"/><label for="rq_buchung-on">On</label>
                    <input type="radio" value="0" id="rq_buchung-off" name="rq_buchung" checked/><label for="rq_buchung-off">Off</label>
                </div>
            </div>
            <br class="clear"/>
        </div>
    </div>
</div>


<div class="page" id="bonus-page" style="display:none">
    <div class="bonus-list">
        <span class="empty">No bonuses</span>

        <div class="bonus-list">
        </div>

        <button id="bonusnew-open">Neueu bonus</button>
        <br class="clear"/>

        <div class="bonus-item example" style="display:none">

            <div class="bonus-preview">
                <p></p>

                <div class="preview-buttons">
                    <button class="bonus-edit">Edit</button>
                    <button class="bonus-delete">Delete</button>
                    <br class="clear"/>
                </div>
                <br class="clear"/>
            </div>

            <div class="bonus-content" style="display:none">

                <div class="period-param param">
                    <label for="von">Period von</label>
                    <input type="text" for-name="bonus_von" class="bonus-von" maxlength="8"/>
                    <label for="bis">bis</label>
                    <input type="text" for-name="bonus_bis" class="bonus-bis" maxlength="8"/>
                </div>

                <div class="bonus-blocks">

                    <div id="bonus_1_block" class="bonus-block active">
                        <div class="radio">
                            <input type="radio" for-name="bonus_type" class="bonustype" value="night_bonus" checked/><label>Nachte bonus</label>
                        </div>

                        <div class="param">
                            <label>Nachte</label>
                            <input type="text" for-name="from_nights" maxlength="2" id="from"/> = <input type="text" for-name="to_nights" maxlength="2" id="to"/>
                        </div>
                    </div>

                    <div id="bonus_2_block" class="bonus-block">
                        <div class="radio">
                            <input type="radio" for-name="bonustype" class="bonustype" value="earlybird_days"/><label>EarlyBird(days)</label>
                        </div>

                        <div class="param">
                            <label>Days before</label>
                            <input type="text" for-name="days_before" id="days" maxlength="2"/>
                        </div>
                        <div class="param">
                            <label>Discount %</label>
                            <input type="text" for-name="discount1" id="percent" maxlength="2"/>
                        </div>
                    </div>

                    <div id="bonus_3_block" class="bonus-block">
                        <div class="radio">
                            <input type="radio" for-name="bonustype" class="bonustype" value="earlybird_date"/><label>EarlyBird(date)</label>
                        </div>

                        <div class="param">
                            <label>Booking till</label>
                            <input type="text" for-name="booking_till" id="booking_till" maxlength="8"/>
                        </div>
                        <div class="param">
                            <label>Discount %</label>
                            <input type="text" for-name="discount2" id="discount2" maxlength="2"/>
                        </div>
                    </div>

                    <div id="bonus_4_block" class="bonus-block">
                        <div class="radio">
                            <input type="radio" for-name="bonustype" class="bonustype" value="long_stay"/><label>Longstay</label>
                        </div>

                        <div class="param">
                            <label>Days count</label>
                            <input type="text" for-name="days_count" id="days_count" maxlength="2"/>
                        </div>
                        <div class="param">
                            <label>Discount %</label>
                            <input type="text" id="discount3" for-name="discount3" maxlength="2"/>
                        </div>
                    </div>

                    <br class="clear"/>
                </div>

                <div class="buttons">
                    <button class="bonusadd-cancel">Cancel</button>
                    <button class="bonusadd-submit">Add</button>
                    <br class="clear"/>
                </div>

                <br class="clear"/>
            </div>
        </div>

    </div>

</div>

<div class="page" id="kontakt-page" style="display:none">
    <div class="param">
        <label for="vorname">Vorname</label>
        <input type="text" name="kontakt_vorname" id="vorname"/>
    </div>
    <div class="param">
        <label for="nachname">Nachname</label>
        <input type="text" name="kontakt_nachname" id="nachname"/>
    </div>
    <div class="param">
        <label for="strasse">Strasse</label>
        <input type="text" name="kontakt_strasse" id="strasse"/>
    </div>
    <div class="param">
        <label for="postleitzahl">Postleitzahl</label>
        <input type="text" name="kontakt_postleitzahl" id="postleitzahl"/>
    </div>
    <div class="param">
        <label for="ort">Ort</label>
        <input type="text" name="kontakt_ort" id="ort"/>
    </div>
    <div class="param">
        <label for="land">Land</label>
        <input type="text" name="kontakt_land" id="land"/>
    </div>
    <div class="param">
        <label for="phone">Tel. Nr.</label>
        <input type="text" name="kontakt_phone" id="phone"/>
    </div>
    <div class="param">
        <label for="fax">Fax Nr.</label>
        <input type="text" name="kontakt_fax" id="fax"/>
    </div>
    <div class="param">
        <label for="email">E-Mail</label>
        <input type="text" name="kontakt_email" id="email"/>
    </div>
    <div class="param">
        <label for="homepage">Homepage</label>
        <input type="text" name="kontakt_homepage" id="homepage"/>
    </div>

</div>

<div class="submit">

    <input type="submit" name="zimmer_create" value="Apply">
</div>
<br class="clear"/>
</form>
</div>