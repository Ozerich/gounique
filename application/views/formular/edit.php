<div id="dashboard-page">
<? echo form_open("formular/edit/".$formular->id); ?>
<div class="page" id="page1">
    <div class="input" id="vorgangsnummer-wr">
        <label for="vorgangsnummer">Vorgangsnummer:</label>
        <input type="text" noempty id="vorgangsnummer" value="<?=$formular->id?>" name="vorgangsnummer" size="10"/>
        <span class="hiddentext" id="vorgangsnummer_hid"><?=$formular->id?></span>
    </div>
    <? if ($formular->agency->type == 'agency'): ?>
    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input type="text" readonly id="provision" name="provision"
               value="<?if (empty($provision)) echo $provision; else echo "11";?>" size="3"/>
        <span class="hiddentext" id="provision_hid">11</span>
    </div>
    <? endif; ?>
    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" noempty numerical id="personcount" value="<?=$formular->personcount?>" name="personcount"
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
<? if($formular->hotel_list)
    foreach ($formular->hotel_list as $ind => $hotel): ?>
    <? if ($hotel['is_manuel'] == 0): ?>
    <div class="hotel hotel-wr" id="hotel_<?=($ind + 1)?>">
        <div class="input" id="hotelcode-wr">
            <label for="hotelcode">Hotel Code</label>
            <input type="text" name="hotelcode[<?=($ind + 1)?>]" size="8" value="<?=$hotel['code']?>" id="hotelcode"/>
            <span id="hotelname"><?=$hotel['name']?></span>
            <input type="hidden" id="hotelname_hid" name="hotelname[<?=($ind + 1)?>]" value="<?=$hotel['name']?>"/>
        </div>
        <div class="input" id="roomtype-wr">
            <label for="roomtype">Room type</label>
            <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                <? foreach ($hotel['all_params']['room_type'] as $type): ?>
                <option value=<?=$type?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="roomcapacity-wr">
            <label for="roomcapacity">Capacity</label>
            <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                <? foreach ($hotel['all_params']['room_capacity'] as $type): ?>
                <option value=<?=$type?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="service-wr">
            <label for="service">Service</label>
            <select name="service[<?=($ind + 1)?>]" id="service">
                <? foreach ($hotel['all_params']['room_service'] as $type): ?>
                <option value=<?=$type?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="date-wr">
            <span>Date</span><br/>
            <label for="datestart">Von</label>
            <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart" value="<?=$hotel['date_start']?>"
                   size="10"/>
            <br class="clear"/>
            <label for="dateend">Bis&nbsp;</label>
            <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$hotel['date_end']?>" size="10"/>
            <br class="clear"/>
            Days Count <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount"
                              value="<?=$hotel['days_count']?>"
                              size="3"/>
        </div>
        <div class="input" id="nohotel" style="display:none">NOT FOUND</div>
        <div class="input" id="transfer-wr">
            <label for="transfer">Transfer</label>
            <select id="transfer" name="transfer[<?=($ind + 1)?>]">
                <option value="NO"
                    <?if ($hotel['transfer'] == 'NO') echo "selected"?>>KEIN TRANSFER
                </option>
                <option value="IN"
                    <?if ($hotel['transfer'] == 'IN') echo "selected"?>>TRANSFER IN
                </option>
                <option value="OUT"
                    <?if ($hotel['transfer'] == 'OUT') echo "selected"?>>TRANSFER OUT
                </option>
                <option value="RT"
                    <?if ($hotel['transfer'] == 'RT') echo "selected"?>>TRANSFER RT
                </option>
            </select>
        </div>
        <div class="input" id="price-wr">
            <label for="price">Price</label>
            <input id="price" size="4" name="price[<?=($ind + 1)?>]" value="<?=$hotel['price']?>"/>&nbsp;EUR
        </div>
        <br class="clear"/>

        <div class="input" id="remark-wr">
            <label for="remark">Remark</label>
            <input type="text" name="remark[<?=($ind + 1)?>]" id="remark" value="<?=$hotel['remark']?>" size="100"/>
        </div>
        <br class="clear"/>
        <input type="hidden" name="ismanuel[<?=($ind + 1)?>]" value="0" id="ismanuel"/>
    </div>
        <? else: ?>
    <div class="hotel manuelhotel-wr">
        <div class="input">
            <label for="hotelcode">Hotel</label>
            <input type="text" name="hotelname[<?=($ind + 1)?>]" size="20" id="hotelname" value="<?=$hotel['name']?>"/>
        </div>
        <div class="input" id="roomtype-wr">
            <label for="roomtype">Room type</label>
            <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                <? foreach ($all_params['room_type'] as $type): ?>
                <option value=<?=$type?> <?if($type == $hotel['room_type']) echo 'selected'?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="roomcapacity-wr">
            <label for="roomcapacity">Capacity</label>
            <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                <? foreach ($all_params['room_capacity'] as $type): ?>
                <option value=<?=$type?> <?if($type == $hotel['room_capacity']) echo 'selected'?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="service-wr">
            <label for="service">Service</label>
            <select name="service[<?=($ind + 1)?>]" id="service">
                <? foreach ($all_params['room_service'] as $type): ?>
                <option value=<?=$type?> <?if($type == $hotel['room_service']) echo 'selected'?>><?=$type?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="input" id="date-wr">
            <span>Date</span><br/>
            <label for="datestart">Von</label>
            <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart" value="<?=$hotel['date_start']?>"
                   size="10"/>
            <br class="clear"/>
            <label for="dateend">Bis&nbsp;</label>
            <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$hotel['date_end']?>" size="10"/>
            <br class="clear"/>
            Days Count <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount"
                              value="<?=$hotel['days_count']?>"
                              size="3"/>
        </div>
        <div class="input" id="transfer-wr">
            <label for="transfer">Transfer</label>
            <select id="transfer" name="transfer[<?=($ind + 1)?>]">
                <option value="NO">KEIN TRANSFER</option>
                <option value="IN">TRANSFER IN</option>
                <option value="OUT">TRANSFER OUT</option>
                <option value="RT">TRANSFER RT</option>
            </select>
        </div>
        <div class="input" id="price-wr">
            <label for="price">Price</label>
            <input id="price" size="4" name="price[<?=($ind + 1)?>]" value="<?=$hotel['price']?>"/>&nbsp;EUR
        </div>
        <br class="clear"/>

        <div class="input" id="remark-wr">
            <label for="remark">Remark</label>
            <input type="text" name="remark[<?=($ind + 1)?>]" id="remark" size="100" value="<?=$hotel['remark']?>"/>
        </div>
        <br class="clear"/>
        <input type="hidden" name="ismanuel[<?=($ind + 1)?>]" value="1" id="ismanuel"/>
    </div>
        <? endif; ?>
    <? endforeach; ?>
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
<? if($formular->manuel_list)
    foreach ($formular->manuel_list as $ind => $manuel): ?>
<div class="manuel-wr" id="manuel_<?=($ind + 1)?>">
    <div class="input" id="text-wr">
        <input type="text" size="100" value="<?=$manuel['text']?>" name="manueltext[<?=($ind + 1)?>]" id="text"/>
    </div>
    <div class="input" id="date-wr">
        <span>Date</span><br/>
        <label for="datestart">Von</label>
        <input type="text" name="manueldatestart[<?=($ind + 1)?>]" class="datestart"
               value="<?=$manuel['date_start']?>"
               size="10"/>
        <br class="clear"/>
        <label for="dateend">Bis&nbsp;</label>
        <input type="text" name="manueldateend[<?=($ind + 1)?>]" class="dateend" value="<?=$manuel['date_end']?>"
               size="10"/>
        <br class="clear"/>
        Days Count <input type="text" name="manueldayscount[<?=($ind + 1)?>]" class="dayscount"
                          value="<?=$manuel['days_count']?>"
                          size="3"/>
    </div>
    <div class="input" id="price-wr">
        <label for="price">Price</label>
        <input id="price" size="4" name="manuelprice[<?=($ind + 1)?>]" value="<?=$manuel['price']?>"/>&nbsp;EUR
    </div>
    <br class="clear"/>
</div>
    <? endforeach; ?>
</div>
</div>

<div class="page" id="flugpage" style="display:none">
    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flight plan</label>
        <textarea id="flightplan" name="flightplan"><?=$formular->flight_plan?></textarea>
    </div>
    <div class="input" id="flightprice-wr">
        <label for="flightprice">Preis of flight</label>
        <input type="text" id="flightprice" size="5" value="<?=$formular->flight_price?>" name="flightprice"/>
    </div>
    <br class="clear"/>
</div>

<div class="page" id="buttons">
<button class="btn btn-small btn-blue" id="addhotel-button">Add hotel</button>
<button class="btn btn-small btn-blue" id="addmanuelhotel-button">Add manuel hotel</button>
<button class="btn btn-small btn-blue" id="addmanuel-button">Add manuel</button>
<button class="btn btn-small btn-blue" id="flug-button">Flug</button>
<button class="btn btn-small btn-blue" id="fertig-button" name="submit">Fertig</button>
</div>
</form>
</div>