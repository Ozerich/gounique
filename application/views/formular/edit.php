<div id="dashboard-page">
<? echo form_open("formular/edit/" . $formular->id, array("formular_id" => $formular->id)); ?>

<div class="formular-header">
    <div class="type-view">
        Type: <?=$formular->type?>
        <a href="#" id="change-type">Change</a>
    </div>
    <span class="v-num">Vorgangsnummer: <span class="value" id="vnum-value"><?=$formular->v_num?></span></span>
</div>


<div class="type-edit" style="display:none;">
    <div id="type-page" class="type-page">
        <span>Choose formular type:</span>

        <div id="type-radio">
            <input type="radio" <? if ($formular->type == "pausschalreise") echo "selected" ?> name="formular-type"
                   id="type_1" value="pausschalreise"><label for="type_1">Pauschalreise</label>
            <input type="radio" <? if ($formular->type == "bausteinreise") echo "selected" ?> name="formular-type"
                   id="type_2" value="bausteinreise"><label for="type_2">Bausteinreise</label>
            <input type="radio" <? if ($formular->type == "nurflug") echo "selected" ?> name="formular-type" id="type_3"
                   value="nurflug"><label for="type_3">Nur flug</label>
        </div>
        <div id="new-vnum" style="display:none"><br/>Vorgangsnummer: <input type="text" class="vnum-input"
                                                                            value="<?=$formular->v_num?>"/></div>

        <br/>
        <button id="type-submit" class="btn btn-blue">Apply</button>
        &nbsp;<span id="type-error"></span>
    </div>
</div>

<div class="page" id="page1">
    <? if ($formular->agency->type == 'agency'): ?>
    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input type="text" readonly id="provision" name="provision"
               value="<?if (empty($formular->provision)) echo $formular->provision; else echo "11";?>" size="3"/>
        <span class="hiddentext" id="provision_hid">11</span>
    </div>
    <? endif; ?>
    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" noempty numerical id="personcount" value="<?=$formular->person_count?>" name="personcount"
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
<?
if ($hotels)
    foreach ($hotels as $ind => $hotel):

        $params = $hotel->all_params;
        if ($hotel->hotel_id != 0):
            $current_hotel = Hotel::find_by_id($hotel->hotel_id);
            ?>
        <div class="hotel hotel-wr" id="hotel_<?=($ind + 1)?>">
            <div class="input" id="hotelcode-wr">
                <label for="hotelcode">Hotel Code</label>
                <input type="text" name="hotelcode[<?=($ind + 1)?>]" size="8" value="<?=$current_hotel->code?>"
                       id="hotelcode"/>
                <span id="hotelname"><?=$current_hotel->name?></span>
                <input type="hidden" id="hotelname_hid" name="hotelname[<?=($ind + 1)?>]"
                       value="<?=$hotel->hotel_name?>"/>
            </div>
            <div class="input" id="roomtype-wr">
                <label for="roomtype">Room type</label>
                <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                    <? foreach ($params['room_type'] as $type): ?>
                    <option
                        value="<?=$type->id?>" <?if ($type->id == $hotel->roomtype_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="roomcapacity-wr">
                <label for="roomcapacity">Capacity</label>
                <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                    <? foreach ($params['room_capacity'] as $type): ?>
                    <option
                        value="<?=$type->id?>" <?if ($type->id == $hotel->roomcapacity_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="service-wr">
                <label for="service">Service</label>
                <select name="service[<?=($ind + 1)?>]" id="service">
                    <? foreach ($params['hotel_service'] as $type): ?>
                    <option
                        value="<?=$type->id?>" <?if ($type->id == $hotel->hotelservice_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="date-wr">
                <span>Date</span><br/>
                <label for="datestart">Von</label>
                <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart" value="<?=$hotel->date_start->format('dmY');?>"
                       size="10"/>
                <br class="clear"/>
                <label for="dateend">Bis&nbsp;</label>
                <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$hotel->date_end->format('dmY');?>"
                       size="10"/>
                <br class="clear"/>
                Days Count <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount"
                                  value="<?=$hotel->days_count?>"
                                  size="3"/>
            </div>
            <div class="input" id="nohotel" style="display:none">NOT FOUND</div>
            <div class="input" id="transfer-wr">
                <label for="transfer">Transfer</label>
                <select id="transfer" name="transfer[<?=($ind + 1)?>]">
                    <option value="kein"
                        <?if ($hotel->transfer == 'kein') echo "selected"?>>KEIN TRANSFER
                    </option>
                    <option value="in"
                        <?if ($hotel->transfer == 'in') echo "selected"?>>TRANSFER IN
                    </option>
                    <option value="out"
                        <?if ($hotel->transfer == 'out') echo "selected"?>>TRANSFER OUT
                    </option>
                    <option value="rt"
                        <?if ($hotel->transfer == 'rt') echo "selected"?>>TRANSFER RT
                    </option>
                </select>
            </div>
            <div class="input" id="price-wr">
                <label for="price">Price</label>
                <input id="price" size="4" name="price[<?=($ind + 1)?>]" value="<?=$hotel->price?>"/>&nbsp;EUR
            </div>
            <br class="clear"/>

            <div class="input" id="remark-wr">
                <label for="remark">Remark</label>
                <input type="text" name="remark[<?=($ind + 1)?>]" id="remark" value="<?=$hotel->remark?>" size="100"/>
            </div>
            <br class="clear"/>
            <input type="hidden" name="ismanuel[<?=($ind + 1)?>]" value="0" id="ismanuel"/>
            <input type="hidden" name="hotel_id[<?=($ind + 1)?>]" value="<?=$hotel->id?>"/>
        </div>
            <? else: ?>
        <div class="hotel manuelhotel-wr">
            <div class="input">
                <label for="hotelcode">Hotel</label>
                <input type="text" name="hotelname[<?=($ind + 1)?>]" size="20" id="hotelname"
                       value="<?=$hotel->hotel_name?>"/>
            </div>
            <div class="input" id="roomtype-wr">
                <label for="roomtype">Room type</label>
                <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                    <? foreach (RoomType::all() as $type): ?>
                    <option
                        value=<?=$type->id?> <?if ($type->id == $hotel->roomtype_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="roomcapacity-wr">
                <label for="roomcapacity">Capacity</label>
                <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                    <? foreach (RoomCapacity::all() as $type): ?>
                    <option
                        value=<?=$type->id?> <?if ($type->id == $hotel->roomcapacity_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="service-wr">
                <label for="service">Service</label>
                <select name="service[<?=($ind + 1)?>]" id="service">
                    <? foreach (HotelService::all() as $type): ?>
                    <option
                        value=<?=$type->id?> <?if ($type->id == $hotel->hotelservice_id) echo 'selected'?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="input" id="date-wr">
                <span>Date</span><br/>
                <label for="datestart">Von</label>
                <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart" value="<?=$hotel->date_start->format('dmY');?>"
                       size="10"/>
                <br class="clear"/>
                <label for="dateend">Bis&nbsp;</label>
                <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$hotel->date_end->format('dmY');?>"
                       size="10"/>
                <br class="clear"/>
                Days Count <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount"
                                  value="<?=$hotel->days_count?>"
                                  size="3"/>
            </div>
            <div class="input" id="transfer-wr">
                <label for="transfer">Transfer</label>
                <select id="transfer" name="transfer[<?=($ind + 1)?>]">
                    <option value="no">KEIN TRANSFER</option>
                    <option value="in">TRANSFER IN</option>
                    <option value="out">TRANSFER OUT</option>
                    <option value="rt">TRANSFER RT</option>
                </select>
            </div>
            <div class="input" id="price-wr">
                <label for="price">Price</label>
                <input id="price" size="4" name="price[<?=($ind + 1)?>]" value="<?=$hotel->price?>"/>&nbsp;EUR
            </div>
            <br class="clear"/>

            <div class="input" id="remark-wr">
                <label for="remark">Remark</label>
                <input type="text" name="remark[<?=($ind + 1)?>]" id="remark" size="100" value="<?=$hotel->remark?>"/>
            </div>
            <br class="clear"/>
            <input type="hidden" name="ismanuel[<?=($ind + 1)?>]" value="1" id="ismanuel"/>
            <input type="hidden" name="hotel_id[<?=($ind + 1)?>]" value="<?=$hotel->id?>"/>
        </div>
            <? endif; ?>

        <? endforeach; ?>
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
<? if ($manuels)
    foreach ($manuels as $ind => $manuel): ?>

    <div class="manuel-wr" id="manuel_<?=($ind + 1)?>">
        <input type="hidden" name="manuel_id[<?=($ind + 1)?>]" value="<?=$manuel->id?>"/>

        <div class="input" id="text-wr">
            <input type="text" size="100" value="<?=$manuel->text?>" name="manuel_text[<?=($ind + 1)?>]" id="text"/>
        </div>
        <div class="input" id="date-wr">
            <span>Date</span><br/>
            <label for="datestart">Von</label>
            <input type="text" name="manuel_datestart[<?=($ind + 1)?>]" class="datestart"
                   value="<?=$manuel->date_start->format('dmY');?>"
                   size="10"/>
            <br class="clear"/>
            <label for="dateend">Bis&nbsp;</label>
            <input type="text" name="manuel_dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$manuel->date_end->format('dmY');?>"
                   size="10"/>
            <br class="clear"/>
            Days Count <input type="text" name="manuel_dayscount[<?=($ind + 1)?>]" class="dayscount"
                              value="<?=$manuel->days_count?>"
                              size="3"/>
        </div>
        <div class="input" id="price-wr">
            <label for="price">Price</label>
            <input id="price" size="4" name="manuel_price[<?=($ind + 1)?>]" value="<?=$manuel->price?>"/>&nbsp;EUR
        </div>
        <br class="clear"/>
    </div>
        <? endforeach; ?>
</div>
</div>

<div class="page" id="flugpage" style="display:none">
    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flight plan</label>
        <textarea id="flightplan" name="flightplan"><?=$formular->flight_text?></textarea>
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