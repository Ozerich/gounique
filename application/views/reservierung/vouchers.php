<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a
                    href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a>
            </li>
            </li>
            <li><a href="reservierung/final/<?=$formular->id?>">formular <?=$formular->v_num?></a></li>
            <li><span>vouchers</span></li>
        </ul>
    </div>
</div>

<div id="vouchers-page" class="reservierung-page content">
    <div class="formular-header">
        <div class="left-block">
            <div class="param">
                <span class="param-name">Kundennummer:</span>
                <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
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
                        <option <?=$formular->owner_type == $ind ? 'selected' : ''?>
                                value="<?=$ind?>"><?=$type?></option>
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

            <div class="param">
                <span class="param-name">Sachbearbeiter:</span>
                <span class="param-value"><?=$formular->sachbearbeiter->fullname?></span>
            </div>

        </div>
        <br class="clear"/>
    </div>

    <? foreach ($formular->hotels_and_manuels as $item): ?>
    <div class="voucher" id="voucher_<?=$item->id?>">
        <input type="hidden" name="item-type" value="<?=$item->type?>"/>

        <div class="voucher-preview">
            <p class="preview-text"><?=$item->plain_text?></p>
            <button class="openclose-button">Print</button>
        </div>
        <div class="voucher-content">
            <div class="incoming-wr">
                <label for="incoming">Incoming agency:</label>
                <select id="incoming">
                    <? foreach ($incoming as $ind => $kunde): ?>
                    <option <?=$kunde->id == $item->incoming_id ? "selected" : ""?>
                            value="<?=$kunde->id?>"><?=$kunde->name?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="persons-block">
                <h3 class="header">Persons:</h3>
                <? foreach ($formular->persons as $person): ?>
                <input type="checkbox" name="person_for_<?=$item->id?>[]"
                       value="<?=$person->id?>"/><?= $person->plain_text ?><br/>
                <? endforeach; ?>
            </div>
            <div class="bottom-block">
                <button class="print-button">Print</button>
                <span class="status">Select persons and press Print</span>
            </div>
        </div>
    </div>
    <? endforeach; ?>
    <div class="buttons">
        <a href="reservierung/final/<?=$formular->id?>" class="button-link">Back</a>
    </div>
</div>