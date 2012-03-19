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
    <input type="hidden" id="formular-mode" value="create"/>

    <? echo form_open("reservierung/create/" . $kunde->id); ?>

    <div id="changeowner_type">
        <? foreach (Formular::$OWNER_TYPES as $ind => $type): ?>
        <input type="radio" name="owner_type" id="ownertype_<?=$ind?>"  value="<?=$ind?>" <?=$ind == 1 ? 'checked' : ''?>/>
        <label for="ownertype_<?=$ind?>"><?=$type?></label>
        <? endforeach; ?>
    </div>

    <div class="changetype-block">
        <div id="type-radio">
            <input type="radio" name="formular-type" id="type_1" checked value="pausschalreise"><label
                for="type_1">Pauschalreise</label>
            <input type="radio" name="formular-type" id="type_2" value="bausteinreise"><label
                for="type_2">Bausteinreise</label>
            <input type="radio" name="formular-type" id="type_3" value="nurflug"><label for="type_3">Nur flug</label>
        </div>
        <br/>
        <ul id="type-error" class="alert-block" style="display: none">
        </ul>

        <div class="typeedit-block" id="pausschalreise-type">

            <div class="vorgansnummer-wr">
                <label for="vorgangsnummer">Vorgangsnummer:</label>
                <input type="text" name="p_vnum" maxlength="6" class="vnum-input"/>
            </div>

            <label for="flight-text">Flugplan</label>
            <textarea class="flight-text" name="p_flight"></textarea>

            <label for="flight-price">Flugpreis:</label>
            <input type="text" maxlength="8" name="p_flightprice" class="flight-price"/> &euro;

        </div>

        <div class="typeedit-block" id="bausteinreise-type" style="display:none">
            <label for="flight-text">Flugplan</label>
            <textarea class="flight-text" name="b_flight"></textarea>

            <label for="flight-price">Flugpreis:</label>
            <input type="text" class="flight-price" name="b_flightprice" maxlength="8"/> &euro;

            <input type="hidden" name="b_vnum" value="" id="b_vnum"/>
        </div>

        <div class="typeedit-block" id="nurflug-type" style="display:none">

            <div class="info-block">
                <h2>Ahtung!</h2>

                <p>Text</p>
            </div>

            <div class="vorgansnummer-wr">
                <label for="vorgangsnummer">Vorgangsnummer:</label>
                <input type="text" name="n_vnum" maxlength="6" class="vnum-input"/>
            </div>

            <div>
                <label for="person-count">Person Count:</label>
                <input type="text" class="person-count" name="n_personcount" maxlength="2"/>
            </div>

            <label for="flight-text">Flugplan:</label>
            <textarea id="flight-text" name="n_flight"></textarea>

            <label for="flight-price">Flugpreis:</label>
            <input type="text" class="flight-price" name="n_flightprice" maxlength="8"/> &euro;

            <div class="service-charge">
                <label for="servicecharge-amount">Service charge:</label>
                <input type="text" maxlength="7" class="servicecharge" name="n_servicecharge"
                       id="servicecharge-amount"/> &euro;
                or <input type="text" maxlength="4" class="servicecharge-percent" id="servicecharge-percent"/> % <br/>
                <label for="total-amount">Total:</label>
                <input value="0" type="text" disabled id="total-amount"/> &euro;
            </div>

        </div>

        <input type="submit" value="Weiter" id="create-submit"/>

    </div>

    </form>

</div>
</div>