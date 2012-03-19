<input type="hidden" name="item-id" value="<?=$item->id?>"/>
<? if ($item->type == "manuel"): ?>
<input type="hidden" name="item-type" value="manuel"/>
<div class="dialog-header">
    <a href="#" class="close">x</a>

    <h3>Manuel #<?=$item->id?></h3>
</div>
<div class="alert-message success" style="display:none"></div>
<div class="alert-message error" style="display:none"></div>
<div class="dialog-content">
    <div class="param">
        <label class="param-name">Incoming</label>
        <select name="incoming">
            <option value="0">No Incoming</option>
            <? foreach (Incoming::all() as $incoming): ?>
            <option  <?=$item->incoming_id == $incoming->id ? "selected" : ''?>
                    value="<?=$incoming->id?>"><?=$incoming->name?></option>
            <? endforeach; ?>
        </select>
    </div>

    <div class="param">
        <label class="param-name" for="manuel_text">Text</label>
        <textarea name="text" class="date-manueltext" id="manuel_text"><?=$item->text?></textarea>
    </div>

    <div class="params-block">
        <input type="checkbox" <?=$item->date_start ? 'checked' : ''?> name="date_enabled" id="date_enabled"/>
        <div class="param">
            <label class="param-name">Von</label>
            <input type="text" name="date_start" class="date_start" maxlength="8"
                   value="<?=$item->date_start ? $item->date_start->format('dmY') : ''?>" <?=$item->date_start ? '' : 'disabled'?> size="10"/>
        </div>

        <div class="param">
            <label class="param-name">Bis&nbsp;</label>
            <input type="text" name="date_end" class="date_end" maxlength="8"
                   value="<?=$item->date_end ? $item->date_end->format('dmY') : ''?>" <?=$item->date_start ? '' : 'disabled'?> size="10"/>
        </div>

        <div class="param">
            <label class="param-name">Nights Count</label>
            <input type="text" name="days_count" class="days_count" maxlength="3" <?=$item->date_start ? '' : 'disabled'?> value="<?=$item->days_count?>"
                   size="3"/>
        </div>

    </div>

    <div class="param">
        <label class="param-name" for="price">Price &euro;</label>
        <input id="price" type="text" size="4" class="price" value="<?=$item->price?>" name="price"/>
        <select id="count" name="count">
            <? for ($i = 1; $i < 10; $i++): ?>
            <option <?=$i == $item->count ? 'selected' : ''?> value="<?=$i?>">x<?=$i?></option>
            <? endfor; ?>
        </select>
        <span class="total-price"><span class="value">0</span> &euro;</span>
    </div>

    <div class="param">
        <label class="param-name" for="voucher_remark">Voucher remark</label>
        <textarea id="voucher_remark" class="voucher-text" name="voucher_remark"><?=$item->voucher_remark?></textarea>
    </div>

    <input type="hidden" name="item-type" value="manuel"/>
</div>
<div class="dialog-footer">
    <button class="cancel">Abbrechen</button>
    <button class="save">Save</button>
</div>
<? elseif ($item->type == "hotel"): ?>
<input type="hidden" name="item-type" value="hotel"/>
<div class="dialog-header">
    <a href="#" class="close">x</a>

    <h3>Hotel #<?=$item->id?></h3>
</div>
<div class="alert-message success" style="display:none"></div>
<div class="alert-message error" style="display:none"></div>
<div class="dialog-content">
    <div class="param">
        <label class="param-name">Incoming</label>
        <select name="incoming">
            <option value="0">No Incoming</option>
            <? foreach (Incoming::all() as $incoming): ?>
            <option  <?=$item->incoming_id == $incoming->id ? "selected" : ''?>
                    value="<?=$incoming->id?>"><?=$incoming->name?></option>
            <? endforeach; ?>
        </select>
    </div>

    <div class="param">
        <label for="hotelname">Hotel Name</label>
        <input type="text" name="hotelname" size="8" maxlength="150" value="<?=$item->hotel_name?>" id=" hotelname"/>
    </div>


    <div class="param">
        <label class="param-name" for="roomtype">Room type</label>
        <input type="text" id="roomtype" maxlength="100" value="<?=$item->roomtype?>" name="roomtype"/>
    </div>

    <div class="params-block">

        <div class="param">
            <label class="param-name" for="roomcapacity">Capacity</label>
            <select name="roomcapacity" id="roomcapacity">
                <option value="EZ" <?if ($item->roomcapacity == 'EZ') echo 'selected';?> >EZ</option>
                <option value="DZ0" <?if ($item->roomcapacity == 'DZ0') echo 'selected';?>>DZ0</option>
                <option value="DZ2" <?if ($item->roomcapacity == 'DZ2') echo 'selected';?>>DZ2</option>
                <option value="DZ3" <?if ($item->roomcapacity == 'DZ3') echo 'selected';?>>DZ3</option>
            </select>
        </div>

        <div class="param">
            <label class="param-name" for="service">Service</label>
            <select name="service" id="service">
                <? foreach (HotelService::all() as $type): ?>
                <option <?if ($type->id == $item->hotelservice_id) echo 'selected'?>
                        value=<?=$type->id?>><?=$type->value?></option>
                <? endforeach; ?>
            </select>
        </div>

    </div>

    <div class="params-block">

        <div class="param">
            <label class="param-name">Von</label>
            <input type="text" name="date_start" class="date_start" maxlength="8"
                   value="<?=$item->date_start ? $item->date_start->format('dmY') : '';?>" size="10"/>
        </div>

        <div class="param">
            <label class="param-name">Bis&nbsp;</label>
            <input type="text" name="date_end" class="date_end" maxlength="8"
                   value="<?=$item->date_end ? $item->date_end->format('dmY') : '';?>" size="10"/>
        </div>

        <div class="param">
            <label class="param-name">Nights Count</label>
            <input type="text" name="days_count" class="days_count" maxlength="3" value="<?=$item->days_count?>"
                   size="3"/>
        </div>

    </div>

    <div class="params-block">

        <div class="param">
            <label class="param-name" for="transfer">Transfer</label>
            <select id="transfer" name="transfer">
                <option value="kein" <? if ($item->transfer == 'kein') echo 'selected'?>>KEIN TRANSFER</option>
                <option value="in" <? if ($item->transfer == 'in') echo 'selected'?>>TRANSFER IN</option>
                <option value="out" <? if ($item->transfer == 'out') echo 'selected'?>>TRANSFER OUT</option>
                <option value="rt" <? if ($item->transfer == 'rt') echo 'selected'?>>TRANSFER RT</option>
            </select>
        </div>

        <div class="param">
            <label class="param-name" for="transfer_price">Transfer Price &euro;</label>
            <input type="text" class="transfer-price price" value="<?=$item->transfer_price?>" id="transfer_price"
                   maxlength="10"
                   name="transfer_price" <?=$hotel->transfer == 'kein' ? 'disabled' : ''?>/>
        </div>

    </div>

    <div class="param">
        <label class="param-name" for="price">Price &euro;</label>
        <input id="price" size="4" maxlength="10" class="price" value="<?=$item->price?>" type="text" name="price"/>

        <select id="count" name="count">
            <? for ($i = 1; $i < 10; $i++): ?>
            <option <?=$i == $item->count ? 'selected' : ''?> value="<?=$i?>">x<?=$i?></option>
            <? endfor; ?>
        </select>
        <span class="total-price"><span class="value">0</span> &euro;</span>
    </div>


    <div class="param text">
        <label class="param-name" for="remark">Remark</label>
        <textarea id="remark" name="remark"><?=$item->remark?></textarea>
    </div>

    <div class="param text">
        <label class="param-name" for="voucher_remark">Voucher text</label>
        <textarea id="voucher_remark" class="voucher-text" name="voucher_remark"><?=$item->voucher_remark?></textarea>
    </div>
    <input type="hidden" name="item-type" value="hotel"/>
</div>
<div class="dialog-footer">
    <button class="cancel">Abbrechen</button>
    <button class="save">Save</button>
</div>

<? endif; ?>