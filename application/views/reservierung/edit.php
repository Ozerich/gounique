<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></span></li>
            </li>
            <li><span>formular <?=$formular->v_num;?></span></li>
        </ul>
    </div>
</div>


<div id="createformular-page" class="reservierung-page content">
<? echo form_open("reservierung/edit/" . $formular->id); ?>

<div class="formular-header">

    <div class="left-block">

        <div class="param">
            <span class="param-name">Kundensnummer:</span>
            <a href="#"><?=$formular->kunde->k_num?></a>
        </div>

        <div class="param">
            <span class="param-name">Type:</span>
            <a class="param-value" href="#" id="formulartype-value"><?=$formular->type?></a>
        </div>

        <div class="param">
            <span class="param-name">Vorgangsnummer:</span>
            <span class="param-value" id="vorgangsnummer-value"><?=$formular->v_num?></span>
        </div>

    </div>

    <div class="right-block">

        <div class="param">
            <span class="param-name">Status:</span>
            <span class="param-value"><?=$formular->status?></span>
        </div>

    </div>
    <br class="clear"/>

    <div class="custom-block" id="flight-window">
        <h3 class="header">Flugplan: <span class="price"><?=$formular->flight_price?></span> &euro;</h3>
        <pre class="text"><?=$formular->flight_text?></pre>
    </div>

</div>

<div class="changetype-block" style="display:none">

    <label>Choose formular type:</label>

    <div id="type-radio">
        <input type="radio" name="formular-type"
               id="type_1" <?if ($formular->type == "pausschalreise") echo 'checked';?> value="pausschalreise"><label
            for="type_1">Pauschalreise</label>
        <input type="radio" name="formular-type" id="type_2" <?if ($formular->type == "bausteinreise") echo 'checked';?>
               value="bausteinreise"><label
            for="type_2">Bausteinreise</label>
        <input type="radio" name="formular-type" id="type_3" <?if ($formular->type == "nurflug") echo 'checked';?>
               value="nurflug"><label for="type_3">Nur flug</label>
    </div>

    <div class="type-edit">

        <div class="vorgansnummer-wr">
            <label for="vorgangsnummer">Vorgangsnummer:</label>
            <input type="text" class="vnum-input" name="formular-vnum" value="<?=$formular->v_num?>"/>
        </div>

        <label for="flight-text">Flight plan</label>
        <textarea id="flight-text" name="flight-text"><?=$formular->flight_text?></textarea>

        <label for="flight-price">Flight price &euro;</label>
        <input type="text" name="flight-price" id="flight-price" value="<?=$formular->flight_price?>"/>
    </div>

    <div class="bottom-block">
        <p class="error" id="type-error"></p>
        <button id="type-submit">Next</button>
        <br class="clear"/>
    </div>

</div>

<div class="formular-content">

<div id="intro-page">
    <div class="input" id="provision-wr">
        <label for="provision">Provision %:</label>
        <input type="text" id="provision" name="provision"
               value="<?=$formular->provision?>" size="3"/>
    </div>
    <div class="input" id="personcount-wr">
        <label for="personcount">Personen:</label>
        <input type="text" id="personcount" value="<?=$formular->person_count?>" name="personcount"
               size="2"/>
    </div>
    <br class="clear"/>
</div>

<div id="item-list" class="param-block">
<? foreach ($formular->hotels as $ind => $hotel): ?>
<input type="hidden" name="formular_hotel_id[<?=($ind + 1)?>]" value="<?=$hotel->id?>"/>

<div class="hotel hotel-wr">

    <div class="hotel-preview block-preview">
        <p class="text"><?=$hotel->date_start->format('d.m.Y') . ' - ' . $hotel->date_end->format('d.m.Y') . '&nbsp;&nbsp;&nbsp;' . $hotel->hotel_name;?></p>
        <button class="edit">Edit</button>
        <br class="clear"/>
    </div>

    <div class="hotel-editcontent" style="display:none">

        <? if ($hotel->hotel_id != 0): ?>

        <div class="database-hotel">
            <div class="param">
                <label class="param-name" for="hotelcode">Hotel Code</label>
                <input type="text" name="hotelcode[<?=($ind + 1)?>]" size="8" id="hotelcode"
                       value="<?=$hotel->hotel_code?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="hotelname">Hotel Name</label>
                <input type="text" size="8" disabled id="hotelname" value="<?=$hotel->hotel_name?>"/>
                <input type="hidden" name="hotelname[<?=($ind + 1)?>]" id="hotelname_hid"
                       value="<?=$hotel->hotel_name?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="roomtype">Room type</label>
                <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                    <? foreach ($hotel->all_params['room_type'] as $roomtype): ?>
                    <option <?if ($roomtype->id == $hotel->roomtype_id) echo 'selected'?>
                            value="<?=$roomtype->id?>"><?=$roomtype->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="roomcapacity">Capacity</label>
                <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                    <? foreach ($hotel->all_params['room_capacity'] as $roomcapacity): ?>
                    <option <?if ($roomcapacity->id == $hotel->roomtype_id) echo 'selected'?>
                            value="<?=$roomcapacity->id?>"><?=$roomcapacity->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="service">Service</label>
                <select name="service[<?=($ind + 1)?>]" id="service">
                    <? foreach ($hotel->all_params['hotel_service'] as $hotel_service): ?>
                    <option <?if ($hotel_service->id == $hotel->hotelservice_id) echo 'selected'?>
                            value="<?=$hotel_service->id?>"><?=$hotel_service->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="datestart">Von</label>
                <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart" size="10"
                       value="<?=$hotel->date_start->format('dmY')?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="dateend">Bis&nbsp;</label>
                <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend"
                       value="<?=$hotel->date_end->format('dmY')?>" size="10"/>
            </div>

            <div class="param">
                <label class="param-name" for="dayscount">Days Count</label>
                <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount" value="<?=$hotel->days_count?>"
                       size="3"/>
            </div>

            <div class="param">
                <label class="param-name" for="transfer">Transfer</label>
                <select id="transfer" class="transfer" name="transfer[<?=($ind + 1)?>]">
                    <option value="kein" <? if ($hotel->transfer == 'kein') echo 'checked'?>>KEIN TRANSFER</option>
                    <option value="in" <? if ($hotel->transfer == 'in') echo 'checked'?>>TRANSFER IN</option>
                    <option value="out" <? if ($hotel->transfer == 'out') echo 'checked'?>>TRANSFER OUT</option>
                    <option value="rt" <? if ($hotel->transfer == 'rt') echo 'checked'?>>TRANSFER RT</option>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="price">Price &euro;</label>
                <input id="price" class="price" type="text" size="4" name="price[<?=($ind + 1)?>]"
                       value="<?=$hotel->price?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="remark">Remark</label>
                <textarea id="remark" class="remark" name="remark[<?=($ind + 1)?>]"><?=$hotel->remark?></textarea>
            </div>
        </div>

        <? else: ?>
        <div class="manuel-hotel">

            <div class="param">
                <label class="param-name" for="hotelname">Hotel Name</label>
                <input type="text" name="hotelname[<?=($ind + 1)?>]" size="8" id="hotelname"
                       value="<?=$hotel->hotel_name?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="roomtype">Room type</label>
                <select name="roomtype[<?=($ind + 1)?>]" id="roomtype">
                    <? foreach (RoomType::all() as $type): ?>
                    <option <?if ($type->id == $hotel->roomtype_id) echo 'selected'?>
                            value=<?=$type->id?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="roomcapacity">Capacity</label>
                <select name="roomcapacity[<?=($ind + 1)?>]" id="roomcapacity">
                    <? foreach (RoomCapacity::all() as $type): ?>
                    <option <?if ($type->id == $hotel->roomcapacity_id) echo 'selected'?>
                            value=<?=$type->id?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="service">Service</label>
                <select name="service[<?=($ind + 1)?>]" id="service">
                    <? foreach (HotelService::all() as $type): ?>
                    <option <?if ($type->id == $hotel->hotelservice_id) echo 'selected'?>
                            value=<?=$type->id?>><?=$type->value?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="datestart">Von</label>
                <input type="text" name="datestart[<?=($ind + 1)?>]" class="datestart"
                       value="<?=$hotel->date_start->format('dmY');?>" size="10"/>
            </div>

            <div class="param">
                <label class="param-name" for="dateend">Bis&nbsp;</label>
                <input type="text" name="dateend[<?=($ind + 1)?>]" class="dateend"
                       value="<?=$hotel->date_end->format('dmY');?>" size="10"/>
            </div>

            <div class="param">
                <label class="param-name" for="dayscount">Days Count</label>
                <input type="text" name="dayscount[<?=($ind + 1)?>]" class="dayscount" value="<?=$hotel->days_count?>"
                       size="3"/>
            </div>

            <div class="param">
                <label class="param-name" for="transfer">Transfer</label>
                <select id="transfer" name="transfer[<?=($ind + 1)?>]">
                    <option value="kein" <? if ($hotel->transfer == 'kein') echo 'checked'?>>KEIN TRANSFER</option>
                    <option value="in" <? if ($hotel->transfer == 'in') echo 'checked'?>>TRANSFER IN</option>
                    <option value="out" <? if ($hotel->transfer == 'out') echo 'checked'?>>TRANSFER OUT</option>
                    <option value="rt" <? if ($hotel->transfer == 'rt') echo 'checked'?>>TRANSFER RT</option>
                </select>
            </div>

            <div class="param">
                <label class="param-name" for="price">Price &euro;</label>
                <input id="price" size="4" type="text" name="price[<?=($ind + 1)?>]" value="<?=$hotel->price?>"/>
            </div>

            <div class="param">
                <label class="param-name" for="remark">Remark</label>
                <textarea id="remark" name="remark[<?=($ind + 1)?>]"><?=$hotel->remark?></textarea>
            </div>


        </div>

        <? endif; ?>

        <div class="buttons">
            <button class="close-button">Close</button>
        </div>
    </div>
</div>
    <? endforeach; ?>
<? foreach ($formular->manuels as $ind => $manuel): ?>
<input type="hidden" name="formular_manuel_id[<?=($ind + 1)?>]" value="<?=$manuel->id?>"/>

<div class="manuel-wr manuel">

    <div class="manuel-preview block-preview">
        <p class="text"><?=($manuel->date_start && $manuel->date_end) ? $manuel->date_start->format('d-m-Y')." - ".$manuel->date_end->format('d-m-Y')." ".$manuel->text : $manuel->text?></p>
        <button class="edit">Edit</button>
        <br class="clear"/>
    </div>

    <div class="manuel-editcontent" style="display:none">

        <? if($manuel->date_start && $manuel->date_end): ?>
        <div class="manuel-date">

            <div class="param">
                <label class="param-name" for="manuel_text">Text</label>
                <textarea name="manuel_text[<?=($ind + 1)?>]" class="date-manueltext" id="manuel_text"><?=$manuel->text;?></textarea>
            </div>

            <div class="param">
                <label class="param-name" for="datestart">Von</label>
                <input type="text" name="manuel_datestart[<?=($ind + 1)?>]" class="datestart" value="<?=$manuel->date_start->format('dmY');?>" size="10"/>
            </div>

            <div class="param">
                <label class="param-name" for="dateend">Bis&nbsp;</label>
                <input type="text" name="manuel_dateend[<?=($ind + 1)?>]" class="dateend" value="<?=$manuel->date_end->format('dmY');?>" size="10"/>
            </div>

            <div class="param">
                <label class="param-name" for="dayscount">Days Count</label>
                <input type="text" name="manuel_dayscount[<?=($ind + 1)?>]" class="dayscount" value="<?=$manuel->days_count?>" size="3"/>
            </div>

            <div class="param">
                <label class="param-name" for="price">Price &euro;</label>
                <input id="price" type="text" size="4" name="manuel_price[<?=($ind + 1)?>]" value="<?=$manuel->price;?>"/>
            </div>

        </div>
        <? else: ?>

        <div class="manuel-nodate">

            <div class="param">
                <label class="param-name" for="manuel_text">Text</label>
                <textarea name="manuel_text[<?=($ind + 1)?>]" class="nodate-manueltext" id="manuel_text"><?=$manuel->text;?></textarea>
            </div>

            <div class="param">
                <label class="param-name" for="price">Price &euro;</label>
                <input id="price" type="text" size="4" name="manuel_price[<?=($ind + 1)?>]" value="<?=$manuel->price;?>"/>
            </div>
        </div>

        <? endif; ?>

        <div class="buttons">
            <button class="close-button">Close</button>
        </div>

    </div>
</div>
    <? endforeach; ?>
</div>

<div class="param-block hidden-param-block" id="hotels">
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
                    <input type="text" name="hotelcode" size="8" id="hotelcode"/>
                </div>

                <div class="param">
                    <label class="param-name" for="hotelname">Hotel Name</label>
                    <input type="text" size="8" disabled id="hotelname"/>
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
                    <label class="param-name" for="transfer">Transfer</label>
                    <select id="transfer" class="transfer" name="transfer" disabled="disabled">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" class="price" type="text" size="4" name="price" disabled="disabled"/>
                </div>

                <div class="param">
                    <label class="param-name" for="remark">Remark</label>
                    <textarea id="remark" class="remark" name="remark" disabled="disabled"></textarea>
                </div>

            </div>

            <div class="manuel-hotel" style="display:none">

                <div class="param">
                    <label class="param-name" for="hotelname">Hotel Name</label>
                    <input type="text" name="hotelname" size="8" id="hotelname"/>
                </div>

                <div class="param">
                    <label class="param-name" for="roomtype">Room type</label>
                    <select name="roomtype" id="roomtype">
                        <? foreach (RoomType::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="roomcapacity">Capacity</label>
                    <select name="roomcapacity" id="roomcapacity">
                        <? foreach (RoomCapacity::all() as $type): ?>
                        <option value=<?=$type->id?>><?=$type->value?></option>
                        <? endforeach; ?>
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
                    <label class="param-name" for="transfer">Transfer</label>
                    <select id="transfer" name="transfer">
                        <option value="kein">KEIN TRANSFER</option>
                        <option value="in">TRANSFER IN</option>
                        <option value="out">TRANSFER OUT</option>
                        <option value="rt">TRANSFER RT</option>
                    </select>
                </div>

                <div class="param">
                    <label class="param-name" for="price">Price &euro;</label>
                    <input id="price" size="4" type="text" name="price"/>
                </div>

                <div class="param">
                    <label class="param-name" for="remark">Remark</label>
                    <textarea id="remark" name="remark"></textarea>
                </div>


            </div>

            <div class="buttons">
                <button class="cancel">Cancel</button>
                <button class="add" disabled>Add</button>
            </div>
        </div>
    </div>
</div>

<div class="param-block hidden-param-block" id="manuels">
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
            </div>

            <div class="buttons">
                <button class="cancel">Cancel</button>
                <button class="add">Add</button>
            </div>

        </div>
    </div>
</div>

<div class="page" id="flugpage" style="display:none">

    <div class="input" id="flightplan-wr">
        <label for="flightplan">Flight plan</label>
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
    <button class="btn btn-small btn-blue" id="addhotel-button">Add hotel</button>
    <button class="btn btn-small btn-blue" id="addmanuel-button">Add manuel</button>
    <button class="btn btn-small btn-blue" id="flug-button">Flug</button>
    <button class="btn btn-small btn-blue" id="fertig-button" name="submit">Fertig</button>
</div>


<input type="hidden" name="kunde_id" value="<?=$kunde->id?>"/>

</form>

</div>
</div>