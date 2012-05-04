<div id="new_flight_block" class="new_flight_block modal-dialog" style="display:block">
    <div class="dialog-header">
        <a href="#" class="close" onclick="return close_flight_popup()">x</a>

        <h3>Flight: <?=$flight->carrier . '-' . $flight->flug_num?></h3>
    </div>

    <div class="alert-message success" style="display:none"></div>
    <div class="alert-message error" style="display:none"></div>
    <div class="dialog-content flight-form" id="flight_form">
        <div class="main-info block-line">
            <div class="param">
                <label for="carrier">Carrier</label>
                <input type="text" maxlength="10" id="carrier" value="<?=$flight->carrier?>" name="carrier"/>
            </div>

            <div class="param">
                <label for="flug_num">Flug Nr.</label>
                <input type="text" maxlength="10" id="flug_num" value="<?=$flight->flug_num?>" name="flug_num"/>
            </div>

            <div class="param">
                <label for="int_num">Int. Nr.</label>
                <input type="text" maxlength="10" id="int_num" value="<?=$flight->int_num?>" name="int_num"/>
            </div>

            <div class="param">
                <label for="marge">Marge %</label>
                <input type="text" maxlength="10" value="<?=$flight->marge?>" id="marge" name="marge"/>
            </div>

        </div>

        <div class="tlc-info block-line">
            <div class="param">
                <label for="tlc_from">Abflughafen</label>
                <input type="text" maxlength="10" id="tlc_from" value="<?=$flight->tlc_from?>" name="tlc_from"/>
            </div>

            <div class="param">
                <label for="tlc_to">Zielflughafen</label>
                <input type="text" maxlength="10" id="tlc_to" value="<?=$flight->tlc_to?>" name="tlc_to"/>
            </div>
        </div>

        <div class="checkboxes block-line">
            <div class="param">
                <label for="crs">CRS Sichtbar<input <?=$flight->active ? 'checked' : ''?> type="checkbox" name="crs"
                                                                                          id="crs"/></label>
            </div>
            <div class="param">
                <label for="hotel_bindung">Hotel Bindung<input
                    type="checkbox" <?=$flight->hotel_bindung ? 'checked' : ''?>  name="hotel_bindung"
                    id="hotel_bindung"/></label>
            </div>
        </div>

        <div class="taxes-info block-line">
            <div class="param">
                <label for="carrier">Tax - Gebühren</label>
                <input type="text" maxlength="10" id="tax_1" value="<?=$flight->tax_1?>" name="tax_1"/>
            </div>

            <div class="param">
                <label for="tax_2">NF Zuschlag</label>
                <input type="text" maxlength="10" id="tax_2" value="<?=$flight->tax_2?>" name="tax_2"/>
            </div>

            <div class="param">
                <label for="tax_3">Sicherheitsgebühr</label>
                <input type="text" maxlength="10" id="tax_3" value="<?=$flight->tax_3?>" name="tax_3"/>
            </div>

            <div class="param">
                <label for="tax_4">Kerosinzuschlag</label>
                <input type="text" maxlength="10" id="tax_4" value="<?=$flight->tax_4?>" name="tax_4"/>
            </div>

        </div>

        <div class="class-info block-line">
            <span class="block-header">Klasses:</span>

            <div class="classes">
                <div class="class example" style="display: none">
                    <label class="class-name">Klasse A:</label>
                    <input type="text" maxlength="2" for-name="from"/> - <input type="text" maxlength="2"
                                                                                for-name="to"/>
                    <label class="tax-need">Zuschläge gültig<input for-name="tax_need" type="checkbox"/></label>
                    <a href="#" class="delete" onclick="delete_class(this); return false;"></a>
                </div>
                <? foreach ($flight->classes as $ind=>$class): ?>
                <div class="class">
                    <label class="class-name">Klasse <?=chr(ord('A') + $ind)?>:</label>
                    <input type="text" value="<?=$class->from?>" maxlength="2" name="from[<?=($ind + 1)?>]"/> - <input type="text" maxlength="2" value="<?=$class->to?>"
                                                                                name="to[<?=($ind + 1)?>]"/>
                    <label class="tax-need">Zuschläge gültig<input name="tax_need[<?=($ind + 1)?>]" <?=$class->tax_need ? 'checked' : ''?> type="checkbox"/></label>
                    <a href="#" class="delete" onclick="delete_class(this); return false;"></a>
                </div>
                <? endforeach; ?>
            </div>
            <button id="new-class" onclick="return new_class();">New Klasse</button>
        </div>

    </div>
    <div class="dialog-footer">
        <button class="cancel" onclick="return close_flight_popup()">Abbrechen</button>
        <button class="add" onclick="return saveflight_submit(<?=$flight->id?>)">Save</button>
    </div>
    <div class="dialog-loading-overlay">
        <span>Loading...</span>
    </div>
</div>