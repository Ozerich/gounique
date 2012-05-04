<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a
                href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a>
            </li>
            <li><span>formular <?=$formular->v_num;?></span></li>
        </ul>
    </div>
</div>


<div id="createformular-page" class="reservierung-page content">

<input type="hidden" id="formular-mode" value="edit"/>
<input type="hidden" id="formular_id" value="<?=$formular->id?>"/>

<? echo form_open("reservierung/edit/" . $formular->id); ?>
<div class="formular-header" style="display:<?=$formular->type == 'nurflug' ? 'none' : 'block'?>">
    <div class="left-block">
        <div class="param">
            <span class="param-name">Kundennummer:</span>
            <a id="kunde_link" for="<?=$formular->kunde->id?>" href="#"><?=$formular->kunde->k_num?></a>
            <a href="#" id="change-ag" class="edit_16"></a>
            <input type="hidden" id="new_ag_id"/>
            <input type="hidden" id="new_ag_num"/>
            <a href="#" id="save-ag" class="save_16" style="display:none"></a>
            <input id="new_agnum" type="text" maxlength="20" size="20" style="display:none"/>
        </div>

        <div class="param">
            <span class="param-name">Typ:</span>
            <span class="param-value" id="formulartype-value"><?=$formular->type?></span>
        </div>

        <div class="param">
            <span class="param-name">Vorgangsnummer:</span>
            <a href="#" id="vorgangsnummer-value" class="param-value change-value"><?=$formular->v_num?></a>

            <div class="editparam" style="display: none">
                <input type="text" id="new_vnum_value" maxlength="6" value="<?=$formular->v_num?>"/>
                <a href="#" id="save-vnum" class="save_16"></a>
            </div>
        </div>

        <div class="param">
            <span class="param-name">Owner type:</span>
            <a href="#" id="ownertype-value" class="param-value change-value"><?=$formular->plain_ownertype?></a>

            <div class="editparam" style="display: none">
                <select id="new_ownertype_value">
                    <? foreach (Formular::$OWNER_TYPES as $ind => $type): ?>
                    <option <?=$formular->owner_type == $ind ? 'selected' : ''?> value="<?=$ind?>"><?=$type?></option>
                    <? endforeach; ?>
                </select>
                <a href="#" id="save-ownertype" class="save_16"></a>
            </div>
        </div>

    </div>

    <div class="right-block">

        <div class="param">
            <span class="param-name">Status:</span>
            <span class="param-value"><?=$formular->plain_status?></span>
        </div>

        <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
        <div class="param">
            <span class="param-name">Rechnungsnummer:</span>
            <span class="param-value"><?=$formular->r_num?></span>
        </div>
        <? endif; ?>

    </div>
    <br class="clear"/>

    <div class="custom-block" id="flight-window">
        <h3 class="header">Flugplan: <span class="price"><?=$formular->flight_price?></span> &euro;</h3>
        <pre class="text"><?=$formular->flight_text?></pre>
    </div>
</div>

<div class="changetype-block" style="display:<?=$formular->type == 'nurflug' ? 'block' : 'none'?>">

    <ul id="type-error" class="alert-block" style="display: none">

    </ul>

    <div class="typeedit-block" id="nurflug-type" <?=$formular->type == 'nurflug' ? '' : 'style="display:none"'?>>

        <div class="info-block">
            <h2>Ahtung!</h2>

            <p>Text</p>
        </div>

        <div>
            <label for="person-count">Person Count:</label>
            <input type="text" class="person-count" name="nurflug_personcount"
                   value="<?=$formular->type == 'nurflug' ? $formular->person_count : ''?>" maxlength="2"/>
        </div>

        <label for="flight-text">Flugplan:</label>
        <textarea id="flight-text"
                  name="nurflug_flight"><?=$formular->type == 'nurflug' ? $formular->flight_text : ''?></textarea>

        <label for="flight-price">Flugpreis:</label>
        <input type="text" class="flight-price" name="nurflug_flightprice" maxlength="7"
               value="<?=$formular->type == 'nurflug' ? $formular->flight_price : ''?>"/> &euro;

        <div class="service-charge">
            <label for="servicecharge-amount">Service charge:</label>
            <input type="text" maxlength="5" class="servicecharge"
                   value="<?=$formular->type == 'nurflug' ? $formular->service_charge : ''?>"
                   name="nurflug_servicecharge" id="servicecharge-amount"/> &euro;
            or <input type="text" maxlength="4" class="servicecharge-percent" id="servicecharge-percent"/> % <br/>
            <label for="total-amount">Total:</label>
            <input
                value="<?=$formular->type == 'nurflug' ? ($formular->flight_price + $formular->service_charge) : ''?>"
                type="text" disabled id="total-amount"/> &euro;
        </div>

        <div class="bottom-block">

            <input type="submit" value="Weiter"/>
            <br class="clear"/>

        </div>

    </div>

</div>

<div class="formular-content" style="display:<?=$formular->type == 'nurflug' ? 'none' : 'block'?>">

<div id="intro-page">

    <? if ($formular->kunde->type == "agenturen"): ?>

    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input disabled type="text" id="provision"
               value="<?=$formular->kunde->provision?>" size="4"/>
    </div>

    <div class="input" id="provision-wr">
        <label for="provision">Manuel Provision %:</label>
        <input type="text"
               value="<?=$formular->kunde->provision != $formular->provision ? $formular->provision : ''?>"
               name="provision-manuel" maxlength="4" size="4"/>
    </div>

    <? endif; ?>

    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" id="personcount" maxlength="2" value="<?=$formular->person_count?>" name="personcount"
               size="2"/>
    </div>
    <br class="clear"/>
</div>

<div id="item-list" class="param-block"><?=$item_list?></div>

<div id="new-hotel" class="modal-dialog new-reservierung-item-block">

    <div class="dialog-header">
        <a href="#" class="close">x</a>

        <h3>New Hotel</h3>
    </div>
    <div class="alert-message success" style="display:none"></div>
    <div class="alert-message error" style="display:none"></div>
    <div class="dialog-content">
        <div class="param">
            <label class="param-name">Incoming</label>
            <select name="incoming">
                <option value="0">No Incoming</option>
                <? foreach (Incoming::all() as $incoming): ?>
                <option value="<?=$incoming->id?>"><?=$incoming->name?></option>
                <? endforeach; ?>
            </select>
        </div>

        <div class="param">
            <label for="hotelname">Hotel Name</label>
            <input type="text" name="hotelname" size="8" maxlength="150" id="hotelname"/>
        </div>


        <div class="param">
            <label class="param-name" for="roomtype">Room type</label>
            <input type="text" id="roomtype" maxlength="100" name="roomtype"/>
        </div>

        <div class="params-block">

            <div class="param">
                <label class="param-name" for="roomcapacity">Capacity</label>
                <select id="count" name="count">
                    <? for ($i = 1; $i < 10; $i++): ?>
                    <option <?=$i == $item->count ? 'selected' : ''?> value="<?=$i?>">x<?=$i?></option>
                    <? endfor; ?>
                </select>
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

        </div>

        <div class="params-block">

            <div class="param">
                <label class="param-name">Von</label>
                <input type="text" name="date_start" class="date_start" maxlength="8" value="" size="10"/>
            </div>

            <div class="param">
                <label class="param-name">Bis&nbsp;</label>
                <input type="text" name="date_end" class="date_end" maxlength="8" value="" size="10"/>
            </div>

            <div class="param">
                <label class="param-name">Nights Count</label>
                <input type="text" name="days_count" class="days_count" maxlength="3" value="0" size="3"/>
            </div>

        </div>

        <div class="params-block">

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
                <input type="text" class="transfer-price price" id="transfer_price" maxlength="10"
                       name="transfer_price" disabled/>
            </div>

        </div>

        <div class="param">
            <label class="param-name" for="price">Price &euro;</label>
            <input id="price" size="4" maxlength="10" class="price" type="text" name="price"/>

            <span class="total-price"><span class="value">0</span> &euro;</span>
        </div>


        <div class="param text">
            <label class="param-name" for="remark">Remark</label>
            <textarea id="remark" name="remark"></textarea>
        </div>

        <div class="param text">
            <label class="param-name" for="voucher_remark">Voucher text</label>
            <textarea id="voucher_remark" class="voucher-text" name="voucher_remark"></textarea>
        </div>
        <input type="hidden" name="item-type" value="hotel"/>
    </div>
    <div class="dialog-footer">
        <button class="cancel">Abbrechen</button>
        <button class="add">Add</button>
    </div>
</div>
<div id="new-manuel" class="modal-dialog new-reservierung-item-block">
    <div class="dialog-header">
        <a href="#" class="close">x</a>

        <h3>New Manuel</h3>
    </div>
    <div class="alert-message success" style="display:none"></div>
    <div class="alert-message error" style="display:none"></div>
    <div class="dialog-content">
        <div class="param">
            <label class="param-name">Incoming</label>
            <select name="incoming">
                <option value="0">No Incoming</option>
                <? foreach (Incoming::all() as $incoming): ?>
                <option value="<?=$incoming->id?>"><?=$incoming->name?></option>
                <? endforeach; ?>
            </select>
        </div>

        <div class="param">
            <label class="param-name" for="manuel_text">Text</label>
            <textarea name="text" class="date-manueltext" id="manuel_text"></textarea>
        </div>

        <div class="params-block">
            <input type="checkbox" checked name="date_enabled" id="date_enabled"/>

            <div class="param">
                <label class="param-name">Von</label>
                <input type="text" name="date_start" class="date_start" maxlength="8" value="" size="10"/>
            </div>

            <div class="param">
                <label class="param-name">Bis&nbsp;</label>
                <input type="text" name="date_end" class="date_end" maxlength="8" value="" size="10"/>
            </div>

            <div class="param">
                <label class="param-name">Nights Count</label>
                <input type="text" name="days_count" class="days_count" maxlength="3" value="0" size="3"/>
            </div>

        </div>

        <div class="param">
            <label class="param-name" for="price">Price &euro;</label>
            <input id="price" type="text" size="4" class="price" name="price"/>
            <select id="count" name="count">
                <? for ($i = 1; $i < 10; $i++): ?>
                <option value="<?=$i?>">x<?=$i?></option>
                <? endfor; ?>
            </select>
            <span class="total-price"><span class="value">0</span> &euro;</span>
        </div>

        <div class="param">
            <label class="param-name" for="voucher_remark">Voucher remark</label>
            <textarea id="voucher_remark" class="voucher-text" name="voucher_remark"></textarea>
        </div>

        <input type="hidden" name="item-type" value="manuel"/>
    </div>
    <div class="dialog-footer">
        <button class="cancel">Abbrechen</button>
        <button class="add">Add</button>
    </div>
</div>

<div id="edit-item" class="modal-dialog new-reservierung-item-block"></div>

<div class="page" id="flugpage" style="display:none">

    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flugplan</label>
        <textarea id="flightplan" name="flight"><?=$formular->flight_text?></textarea>
    </div>
    <div class="input" id="flightprice-wr">
        <label for="flightprice">Preis of flight</label>
        <input type="text" name="flightprice" id="flightprice" size="5" value="<?=$formular->flight_price?>"/>
    </div>

    <br class="clear"/>

    <div class="buttons">
        <button class="close">Close</button>
    </div>

</div>

<div class="formular-buttons buttons-block">
    <button class="btn btn-small btn-blue" id="addhotel-button">Hotel hinzuf&uuml;ggen</button>
    <button class="btn btn-small btn-blue" id="addmanuel-button">Manuelle Leistung</button>
    <button class="btn btn-small btn-blue" id="flug-button">Flug</button>
    <button class="btn btn-small btn-blue" id="fertig-button" name="submit">Fertig</button>
</div>


<input type="hidden" name="kunde_id" value="<?=$kunde->id?>"/>

</form>

</div>
</div>

<div id="item-delete-confirm" style="display:none">
    Are you sure?
</div>
