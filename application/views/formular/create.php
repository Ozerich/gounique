<div id="dashboard-page" class="create-page">
    <? echo form_open("formular/create/" . $agency->id); ?>

    <div class="formular-header" style="display:none">
        <div class="type-view">
            Type: <span id="formular-type-val"><?=$formular->type?></span>
            <a href="#" id="change-type">Change</a>
        </div>
        <span class="v-num">Vorgangsnummer: <span class="value" id="vnum-value"><?=$formular->v_num?></span></span>
        <input type="hidden" value="" name="formular_vnum"/>
    </div>

    <div class="type-edit">
        <div id="type-page" class="type-page">
            <span>Choose formular type:</span>

            <div id="type-radio">
                <input type="radio" name="formular-type" id="type_1" value="pausschalreise"><label for="type_1">Pauschalreise</label>
                <input type="radio" name="formular-type" id="type_2" value="bausteinreise"><label for="type_2">Bausteinreise</label>
                <input type="radio" name="formular-type" id="type_3" value="nurflug"><label for="type_3">Nur flug</label>
            </div>
            <div id="new-vnum" style="display:none"><br/>Vorgangsnummer: <input type="text" class="vnum-input" value="<?=$formular->v_num?>"/></div>

            <br/><button id="type-submit" class="btn btn-blue">Next</button>&nbsp;<span id="type-error"></span>
        </div>
    </div>


    <div class="page" id="page1" style="display:none">
        <? if ($agency->type == 'agency'): ?>
        <div class="input" id="provision-wr">
            <label for="provision">Provision %:</label>
            <input type="text" readonly id="provision" name="provision"
                   value="11" size="3"/>
            <span class="hiddentext" id="provision_hid">11</span>
        </div>
        <? endif; ?>
        <div class="input" id="personcount-wr">
            <label for="personcount">Personen:</label>
            <input type="text" noempty numerical id="personcount" value="" name="personcount"
                   size="2"/>
            <span class="hiddentext" id="personcount_hid"></span>
        </div>
        <br class="clear"/>
    </div>
    <div class="page" id="hotels-page">
        <div class="hotels">
            <div class="hotel hotel-wr" style="display:none">
                <div class="input">
                    <label for="hotelcode">Hotel Code</label>
                    <input type="text" name="hotelcode" size="8" id="hotelcode"/>
                    <span id="hotelname"></span>
                    <input type="hidden" id="hotelname_hid"/>
                </div>
                <div class="input" id="roomtype-wr" style="display:none;">
                    <label for="roomtype">Room type</label>
                    <select name="roomtype" id="roomtype"></select>
                </div>
                <div class="input" id="roomcapacity-wr" style="display:none;">
                    <label for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity"></select>
                </div>
                <div class="input" id="service-wr" style="display:none;">
                    <label for="service">Service</label>
                    <select name="service" id="service"></select>
                </div>
                <div class="input" id="date-wr" style="display:none;">
                    <span>Date</span><br/>
                    <label for="datestart">Von</label>
                    <input type="text" name="datestart" class="datestart" value="" size="10"/>
                    <br class="clear"/>
                    <label for="dateend">Bis&nbsp;</label>
                    <input type="text" name="dateend" class="dateend" value="" disabled size="10"/>
                    <br class="clear"/>
                    Days Count <input type="text" name="dayscount" class="dayscount" disabled value="0" size="3"/>
                </div>
                <div class="input" id="nohotel" style="display:none;">NOT FOUND</div>
                <div class="input" id="transfer-wr" style="display:none">
                    <label for="transfer">Transfer</label>
                    <select id="transfer" name="transfer">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>
                <div class="input" id="price-wr" style="display:none">
                    <label for="price">Price</label>
                    <input id="price" size="4" name="price"/>&nbsp;EUR
                </div>
                <br class="clear"/>

                <div class="input" id="remark-wr" style="display:none">
                    <label for="remark">Remark</label>
                    <input type="text" name="remark" id="remark" size="100"/>
                </div>
                <input type="hidden" name="ismanuel" value="0" id="ismanuel"/>
                <br class="clear"/>
            </div>
            <div class="hotel manuelhotel-wr" style="display:none">
                <div class="input">
                    <label for="hotelcode">Hotel</label>
                    <input type="text" name="hotelname" size="20" id="hotelname"/>
                </div>
                <div class="input" id="roomtype-wr">
                    <label for="roomtype">Room type</label>
                    <select name="roomtype" id="roomtype">
                        <? foreach (RoomType::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="input" id="roomcapacity-wr">
                    <label for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity">
                        <? foreach (RoomCapacity::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="input" id="service-wr">
                    <label for="service">Service</label>
                    <select name="service" id="service">
                        <? foreach (HotelService::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="input" id="date-wr">
                    <span>Date</span><br/>
                    <label for="datestart">Von</label>
                    <input type="text" name="datestart" class="datestart" value="" size="10"/>
                    <br class="clear"/>
                    <label for="dateend">Bis&nbsp;</label>
                    <input type="text" name="dateend" class="dateend" value="" disabled size="10"/>
                    <br class="clear"/>
                    Days Count <input type="text" name="dayscount" class="dayscount" disabled value="0" size="3"/>
                </div>
                <div class="input" id="transfer-wr">
                    <label for="transfer">Transfer</label>
                    <select id="transfer" name="transfer">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>
                <div class="input" id="price-wr">
                    <label for="price">Price</label>
                    <input id="price" size="4" name="price"/>&nbsp;EUR
                </div>
                <br class="clear"/>

                <div class="input" id="remark-wr">
                    <label for="remark">Remark</label>
                    <input type="text" name="remark" id="remark" size="100"/>
                </div>
                <br class="clear"/>
                <input type="hidden" name="ismanuel" value="1" id="ismanuel"/>
            </div>

            <div class="manuel-wr" style="display:none">
                <div class="input" id="text-wr">
                    <input type="text" size="100" name="manuel_text" id="text"/>
                </div>
                <div class="input" id="date-wr">
                    <span>Date</span><br/>
                    <label for="datestart">Von</label>
                    <input type="text" name="manuel_datestart" class="datestart" value="" size="10"/>
                    <br class="clear"/>
                    <label for="dateend">Bis&nbsp;</label>
                    <input type="text" name="manuel_dateend" class="dateend" value="" disabled size="10"/>
                    <br class="clear"/>
                    Days Count <input type="text" name="manuel_dayscount" class="dayscount" disabled value="0"
                                      size="3"/>
                </div>
                <div class="input" id="price-wr">
                    <label for="price">Price</label>
                    <input id="price" size="4" name="manuel_price"/>&nbsp;EUR
                </div>
                <br class="clear"/>
            </div>
        </div>
    </div>

    <div class="page" id="flugpage" style="display:none">
        <div class="input" id="flightplan-wr">
            <label for="flightplan">Flight plan</label>
            <textarea id="flightplan" name="flightplan"></textarea>
        </div>
        <div class="input" id="flightprice-wr">
            <label for="flightprice">Preis of flight</label>
            <input type="text" id="flightprice" size="5" value="" name="flightprice"/>
        </div>
        <br class="clear"/>
    </div>

    <div class="page" id="buttons" style="display:none">
        <button class="btn btn-small btn-blue" id="addhotel-button">Add hotel</button>
        <button class="btn btn-small btn-blue" id="addmanuelhotel-button">Add manuel hotel</button>
        <button class="btn btn-small btn-blue" id="addmanuel-button">Add manuel</button>
        <button class="btn btn-small btn-blue" id="flug-button">Flug</button>
        <button class="btn btn-small btn-blue" id="fertig-button" name="submit">Fertig</button>
    </div>
    <input type="hidden" name="agency_id" value="<?=$agency->id?>"/>
    </form>
</div>