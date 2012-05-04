<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/rundreise">rundreise</a></li>
            <li><span>neue tour</span></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
<?=form_open("product/rundreise/create")?>

<ul id="tabs">
    <li class="active"><span for="crs-page">CRS Daten</span></li>
    <li><span for="klassen-page">Childs & Extras</span></li>
    <li><span for="kontakt-page">Kontaktdaten</span></li>
</ul>

<div class="page" id="crs-page">
    <div class="param">
        <label for="code">Packetcode</label>
        <input name="code" class="high-letters" type="text" id="code" maxlength="10"/>
    </div>

    <div class="param">
        <label for="name">Packetname</label>
        <input name="name" type="text" id="name"/>
    </div>

    <div class="param">
        <label for="category">Kategorie</label>
        <input name="stars" type="text" id="category"/>
    </div>

    <div class="param">
        <label for="tlc">Start TLC</label>
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
        <label for="land">Land</label>
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