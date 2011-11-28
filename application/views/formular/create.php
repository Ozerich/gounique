<div id="dashboard-page">
    <? echo form_open("formular/create/" . $agency->id); ?>
    <div class="page" id="page1">
        <div class="input" id="vorgangsnummer-wr">
            <label for="vorgangsnummer">Vorgangsnummer:</label>
            <input type="text" noempty id="vorgangsnummer" value="<?=$formular_id?>" name="vorgangsnummer" size="10"/>
            <span class="hiddentext" id="vorgangsnummer_hid"><?=$formular_id?></span>
        </div>
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
                        <option value="NO">KEIN TRANSFER</option>
                        <option value="IN">TRANSFER IN</option>
                        <option value="OUT">TRANSFER OUT</option>
                        <option value="RT">TRANSFER RT</option>
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
                        <? foreach ($all_params['room_type'] as $type): ?>
                        <option value=<?=$type?>><?=$type?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="input" id="roomcapacity-wr">
                    <label for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity">
                        <? foreach ($all_params['room_capacity'] as $type): ?>
                        <option value=<?=$type?>><?=$type?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="input" id="service-wr">
                    <label for="service">Service</label>
                    <select name="service" id="service">
                        <? foreach ($all_params['room_service'] as $type): ?>
                        <option value=<?=$type?>><?=$type?></option>
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
                        <option value="NO">KEIN TRANSFER</option>
                        <option value="IN">TRANSFER IN</option>
                        <option value="OUT">TRANSFER OUT</option>
                        <option value="RT">TRANSFER RT</option>
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
                    <input type="text" size="100" name="text" id="text"/>
                </div>
                <div class="input" id="date-wr">
                    <span>Date</span><br/>
                    <label for="datestart">Von</label>
                    <input type="text" name="manueldatestart" class="datestart" value="" size="10"/>
                    <br class="clear"/>
                    <label for="dateend">Bis&nbsp;</label>
                    <input type="text" name="manueldateend" class="dateend" value="" disabled size="10"/>
                    <br class="clear"/>
                    Days Count <input type="text" name="manueldayscount" class="dayscount" disabled value="0"
                                      size="3"/>
                </div>
                <div class="input" id="price-wr">
                    <label for="price">Price</label>
                    <input id="price" size="4" name="manuelprice"/>&nbsp;EUR
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
    </form>
</div>