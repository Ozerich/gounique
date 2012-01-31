<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><a href="product/hotels">hoteldaten</a></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
<?=form_open("product/hotels/create")?>

<ul id="tabs">
    <li class="active"><span for="crs-page">CRS Daten</span></li>
    <li><span for="klassen-page">Klassen & Extras</span></li>
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

    <div class="param">
        <div class="left">
            <label for="min_auf">Min.Auf.</label>
            <input name="min_auf" type="text" id="min_auf"/>
        </div>
        <div class="right">
            <label for="max_auf">Max.Auf.</label>
            <input type="text" name="max_auf" id="max_auf"/>
        </div>
        <br class="clear"/>
    </div>

    <div class="param">
        <label for="service">Hotel Verpflegungs</label>

        <div class="checkbox-block">
            <? foreach (ProductService::all() as $service): ?>
            <div class="checkbox">
                <input type="checkbox" name="service" value="<?=$service->id?>"/><span><?=$service->name?><span>
            </div>
            <? endforeach; ?>
        </div>
    </div>

    <div class="param zimmer-block">
        <label for="zimmer">Hotelzimmer</label>

        <div class="zimmer-new">
            <input type="text" id="zimmer-value"/>
            <button id="zimmer-add">Add</button>
            <input type="hidden" id="zimmer_id"/>
        </div>

        <div class="zimmer-list">
            <div class="item example" style="display:none">
                <span class="zimmer-name"></span>
                <a href="#" class="zimmer-delete"></a>
                <input type="hidden" class="room_id"/>
            </div>

        </div>
    </div>

    <div class="param radios">
        <div class="left">
            <label for="flugbindung">Flugbindung</label>

            <div class="buttonset">
                <input type="radio" value="on" id="flug-on" name="flugbindung"/><label for="flug-on">On</label>
                <input type="radio" value="off" id="flug-off" name="flugbindung" checked/><label
                for="flug-off">Off</label>
            </div>
        </div>
        <div class="right">
            <label for="crs">CRS Status</label>

            <div class="buttonset">
                <input type="radio" value="on" id="crs-on" name="crs"/><label for="crs-on">On</label>
                <input type="radio" value="off" id="crs-off" name="crs" checked/><label for="crs-off">Off</label>
            </div>
        </div>
        <br class="clear"/>
    </div>
</div>

<div class="page" id="klassen-page" style="display: none">
    <div class="klassen-block">
        <span class="block-header">Klassen:</span>

        <div class="klassen-list">
            <span class="empty">No klassen</span>

            <div class="klassen-item example" style="display:none">
                <div class="param">
                    <div class="param-header">
                        <label for="caption">Caption</label>
                        <input type="text" id="caption"/>
                        <a href="#" class="delete-icon klassen-delete"></a>
                    </div>
                    <div class="period-param param">
                        <label for="von">von</label>
                        <input type="text" id="von" maxlength="2"/>
                        <label for="bis">bis</label>
                        <input type="text" id="bis" maxlength="2"/>
                    </div>
                </div>
            </div>
        </div>

        <button id="new-klassen">Neueu klassen</button>
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
                    <input type="text" id="nachte_max"/>
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
                    <input type="radio" value="on" id="optionsbuchung-on" name="optionsbuchung"/><label
                    for="optionsbuchung-on">On</label>
                    <input type="radio" value="off" id="optionsbuchung-off" name="optionsbuchung" checked/><label
                    for="optionsbuchung-off">Off</label>
                </div>
            </div>
            <div class="right">
                <label for="rq_buchung">RQ Buchung</label>

                <div class="buttonset">
                    <input type="radio" value="on" id="rq_buchung-on" name="crs"/><label for="rq_buchung-on">On</label>
                    <input type="radio" value="off" id="rq_buchung-off" name="crs" checked/><label for="rq_buchung-off">Off</label>
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
                    <input type="text" class="bonus-von" maxlength="8"/>
                    <label for="bis">bis</label>
                    <input type="text" class="bonus-bis" maxlength="8"/>
                </div>

                <div class="bonus-blocks">
                    <div id="bonus_1_block" class="bonus-block">
                        <div class="radio">
                            <input type="radio" class="bonustype" value="1" checked/><label>Nachte bonus</label>
                        </div>

                        <div class="param">
                            <label>Nachte</label>
                            <input type="text" maxlength="2" id="from"/> = <input type="text" maxlength="2" id="to"/>
                        </div>
                    </div>

                    <div id="bonus_2_block" class="bonus-block">
                        <div class="radio">
                            <input type="radio" class="bonustype" value="2"/><label>EarlyBird</label>
                        </div>

                        <div class="param">
                            <label>Days before</label>
                            <input type="text" id="days" maxlength="2"/>
                        </div>
                        <div class="param">
                            <label>Discount %</label>
                            <input type="text" id="percent" maxlength="2"/>
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
        <input type="text" name="vorname" id="vorname"/>
    </div>
    <div class="param">
        <label for="nachname">Nachname</label>
        <input type="text" name="nachname" id="nachname"/>
    </div>
    <div class="param">
        <label for="strasse">Strasse</label>
        <input type="text" name="strasse" id="strasse"/>
    </div>
    <div class="param">
        <label for="postleitzahl">Postleitzahl</label>
        <input type="text" name="postleitzahl" id="postleitzahl"/>
    </div>
    <div class="param">
        <label for="ort">Ort</label>
        <input type="text" name="ort" id="ort"/>
    </div>
    <div class="param">
        <label for="land">Land</label>
        <input type="text" name="land" id="land"/>
    </div>
    <div class="param">
        <label for="phone">Tel. Nr.</label>
        <input type="text" name="phone" id="phone"/>
    </div>
    <div class="param">
        <label for="fax">Fax Nr.</label>
        <input type="text" name="fax" id="fax"/>
    </div>
    <div class="param">
        <label for="email">E-Mail</label>
        <input type="text" name="email" id="email"/>
    </div>
    <div class="param">
        <label for="homepage">Homepage</label>
        <input type="text" name="homepage" id="homepage"/>
    </div>

</div>

<div class="submit">

    <input type="submit" name="zimmer_create" value="Apply">
</div>
<br class="clear"/>
</form>
</div>