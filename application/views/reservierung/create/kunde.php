<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung/historie/<?=$kunde->id?>"><?=$kunde->plain_type;?> <?=$kunde->k_num?></a></li>
            </li>
            <li><span>neu formular</span></li>
        </ul>
    </div>
</div>


<div id="createformular-page" class="reservierung-page content">
<? echo form_open("reservierung/create/" . $kunde->id); ?>

<div class="formular-header">

    <div class="left-block">

        <div class="param">
            <span class="param-name">Kundennummer:</span>
            <a href="#"><?=$kunde->k_num?></a>
        </div>

        <div class="param">
            <span class="param-name">Typ:</span>
            <a class="param-value" href="#" id="formulartype-value"></a>
        </div>

        <div class="param">
            <span class="param-name">Vorgangsnummer:</span>
            <span class="param-value" id="vorgangsnummer-value"></span>
        </div>

    </div>

    <div class="right-block">

        <div class="param">
            <span class="param-name">Status:</span>
            <span class="param-value"><?=$formular->plain_status?></span>
        </div>

    </div>
    <br class="clear"/>

    <div class="custom-block" id="flight-window">
        <h3 class="header">Flugplan: <span class="price"></span> &euro;</h3>
        <pre class="text"></pre>
    </div>

</div>

<div class="changetype-block">

    <label>Formulartyp auswahlen:</label>

    <div id="type-radio">
        <input type="radio" name="formular-type" id="type_1" checked value="Pausschalreise"><label
        for="type_1">Pauschalreise</label>
        <input type="radio" name="formular-type" id="type_2" value="Bausteinreise"><label
        for="type_2">Bausteinreise</label>
        <input type="radio" name="formular-type" id="type_3" value="Nurflug"><label for="type_3">Nur flug</label>
    </div>

    <div class="type-edit">

        <div class="vorgansnummer-wr">
            <label for="vorgangsnummer">Vorgangsnummer:</label>
            <input type="text" maxlength="6" class="vnum-input" name="formular-vnum"/>
        </div>

        <label for="flight-text">Flugplan</label>
        <textarea id="flight-text" name="flight-text"></textarea>

        <label for="flight-price">Flugpreis &euro;</label>
        <input type="text" name="flight-price" id="flight-price"/>
    </div>

    <div class="bottom-block">
        <p class="error" id="type-error"></p>
        <button id="type-submit">Weiter</button>
        <br class="clear"/>
    </div>

</div>

<div class="formular-content" style="display:none">
<div id="intro-page">
    <? if ($kunde->type == 'agenturen'): ?>
    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input type="text" id="provision" name="provision"
               value="<?=$kunde->provision?>" maxlength="2" size="2"/>
    </div>
    <? endif; ?>

    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" id="personcount" maxlength="2" value="" name="personcount"
               size="2"/>
    </div>
    <br class="clear"/>
</div>

<div id="item-list" class="param-block">

</div>

<div class="param-block  hidden-param-block" id="hotels">
    <div class="hotel hotel-wr" style="display:none">

        <div class="hotel-preview block-preview" style="display:none">
            <p class="text"></p>
            <button class="edit">Edit</button>
            <br class="clear"/>
        </div>

        <div class="hotel-editcontent">
            <div class="param hoteltype-wr">
                <label class="param-name">Type</label>

                <div id="hoteltype">
                    <input type="radio" name="hoteltype" checked value="database" class="hoteltype-db"
                           id="hoteltype-db"/><label
                    for="hoteltype-db">database</label>
                    <input type="radio" name="hoteltype" value="manuel" class="hoteltype-manuel"
                           id="hoteltype-manuel"/><label
                    for="hoteltype-manuel">manuel</label>
                </div>

            </div>

            <div class="database-hotel">

                <div class="param">
                    <label class="param-name" for="hotelcode">Hotel Code</label>
                    <input type="text" name="hotelcode" size="8" maxlength="8" id="hotelcode"/>
                </div>

                <div class="param">
                    <label class="param-name" for="hotelname">Hotel Name</label>
                    <input type="text" size="8" id="hotelname"/>
                    <input type="hidden" name="hotelname" id="hotelname_hid"/>
                </div>

                <div class="param">
                    <label class="param-name" for="roomtype">Room type</label>
                    <select name="roomtype" id="roomtype" disabled="disabled"></select>
                </div>

                <div class="param">
                    <label class="param-name" for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity" disabled="disabled"></select>
                </div>

                <div class="param">
                    <label class="param-name" for="service">Service</label>
                    <select name="service" id="service" disabled="disabled"></select>
                </div>

                <div class="param">
                    <label class="param-name" for="datestart">Von</label>
                    <input type="text" name="datestart" class="datestart" value="" size="10" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dateend">Bis&nbsp;</label>
                    <input type="text" name="dateend" class="dateend" value="" size="10" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dayscount">Days Count</label>
                    <input type="text" name="dayscount" class="dayscount" value="0" size="3" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" class="price" type="text" size="4" name="price" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="transfer">Transfer</label>
                    <select id="transfer" class="transfer" name="transfer" disabled="disabled">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="transfer_price">Transfer Price &euro;</label>
                    <input type="text" name="transfer_price" class="transfer-price" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="remark">Remark</label>
                    <textarea id="remark" class="remark" name="remark" disabled="disabled"></textarea>
                </div>

                <div class="param">
                    <label class="param-name" for="city_tour">City tour</label>
                    <textarea id="city_tour" class="city-tour" name="city_tour" disabled="disabled"></textarea>
                </div>

                <div class="param">
                    <label class="param-name" for="voucher_remark">Voucher text</label>
                    <textarea id="voucher_remark" class="remark" name="voucher_remark" disabled="disabled"></textarea>
                </div>

            </div>

            <div class="manuel-hotel" style="display:none">

                <div class="param">
                    <label class="param-name" for="hotelname">Hotel Name</label>
                    <input type="text" name="hotelname" size="8" id="hotelname"/>
                </div>

                <div class="param">
                    <label class="param-name" for="roomtype">Room type</label>
                    <input type="text" id="roomtype" name="roomtype" />
                </div>

                <div class="param">
                    <label class="param-name" for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity">
                        <option value="EZ">EZ</option>
                        <option value="DZ0">DZ0</option>
                        <option value="DZ2">DZ2</option>
                        <option value="DZ3">DZ3</option>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="service">Service</label>
                    <select name="service" id="service">
                        <? foreach (HotelService::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="datestart">Von</label>
                    <input type="text" name="datestart" class="datestart" value="" size="10"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dateend">Bis&nbsp;</label>
                    <input type="text" name="dateend" class="dateend" value="" size="10"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dayscount">Days Count</label>
                    <input type="text" name="dayscount" class="dayscount" value="0" size="3"/>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" size="4" type="text" name="price"/>
                </div>

                <div class="param">
                    <label class="param-name" for="transfer">Transfer</label>
                    <select id="transfer" name="transfer">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="transfer_price">Transfer Price &euro;</label>
                    <input type="text" class="transfer-price" id="transfer_price" name="transfer_price"/>
                </div>
                
                <div class="param">
                    <label class="param-name" for="remark">Remark</label>
                    <textarea id="remark" name="remark"></textarea>
                </div>

                <div class="param">
                    <label class="param-name" for="voucher_remark">Voucher text</label>
                    <textarea id="voucher_remark" class="remark" name="voucher_remark"></textarea>
                </div>


            </div>

            <div class="buttons">
                <button class="cancel">Abbrechen</button>
                <button class="add" disabled>Add</button>
            </div>
        </div>
    </div>
</div>

<div class="param-block  hidden-param-block" id="manuels">
    <div class="manuel-wr manuel" style="display:none">

        <div class="manuel-preview block-preview" style="display:none">
            <p class="text"></p>
            <button class="edit">Edit</button>
            <br class="clear"/>
        </div>

        <div class="manuel-editcontent">
            <div class="param manueltype-wr">
                <label class="param-name">Type</label>

                <div class="manueltype" id="manueltype">
                    <input type="radio" name="manueltype" value="with-date" class="manueltype-date"
                           id="manueltype-date"/><label
                    for="manueltype-date">with date</label>
                    <input type="radio" name="manueltype" value="no-date" class="manueltype-nodate"
                           id="manueltype-nodate"/><label
                    for="manueltype-nodate">no date</label>
                </div>
            </div>

            <div class="manuel-date">

                <div class="param">
                    <label class="param-name" for="manuel_text">Text</label>
                    <textarea name="manuel_text" class="date-manueltext" id="manuel_text"></textarea>
                </div>

                <div class="param">
                    <label class="param-name" for="datestart">Von</label>
                    <input type="text" name="manuel_datestart" class="datestart" value="" size="10"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dateend">Bis&nbsp;</label>
                    <input type="text" name="manuel_dateend" class="dateend" value="" size="10"/>
                </div>

                <div class="param">
                    <label class="param-name" for="dayscount">Days Count</label>
                    <input type="text" name="manuel_dayscount" class="dayscount" value="0" size="3"/>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" type="text" size="4" name="manuel_price"/>
                </div>

                <div class="param">
                    <label class="param-name" for="voucher_remark">Voucher text</label>
                    <textarea id="voucher_remark" class="remark" name="manuel_voucher_remark"></textarea>
                </div>

            </div>

            <div class="manuel-nodate" style="display:none">

                <div class="param">
                    <label class="param-name" for="manuel_text">Text</label>
                    <textarea name="manuel_text" class="nodate-manueltext" id="manuel_text"></textarea>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" type="text" size="4" name="manuel_price"/>
                </div>

                <div class="param">
                    <label class="param-name" for="voucher_remark">Voucher text</label>
                    <textarea id="voucher_remark" class="remark" name="manuel_voucher_remark"></textarea>
                </div>

            </div>

            <div class="buttons">
                <button class="cancel">Abbrechen</button>
                <button class="add">Add</button>
            </div>

        </div>
    </div>
</div>

<div class="page" id="flugpage" style="display:none">

    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flugplan</label>
        <textarea id="flightplan"></textarea>
    </div>
    <div class="input" id="flightprice-wr">
        <label for="flightprice">Preis of flight</label>
        <input type="text" id="flightprice" size="5" value=""/>
    </div>

    <br class="clear"/>

    <div class="buttons">
        <button class="close">Close</button>
    </div>

</div>

<div class="formular-buttons buttons-block">
    <button class="btn btn-small btn-blue" id="addhotel-button">Hotel hinzuf&uuml;gen</button>
    <button class="btn btn-small btn-blue" id="addmanuel-button">Manuelle Leistung</button>
    <button class="btn btn-small btn-blue" id="flug-button">Flug</button>
    <button class="btn btn-small btn-blue" id="fertig-button" name="submit">Fertig</button>
</div>


<input type="hidden" name="kunde_id" value="<?=$kunde->id?>"/>

</form>

</div>
</div>