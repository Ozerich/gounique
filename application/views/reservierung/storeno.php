<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a
                href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a>
            </li>
            </li>
            <li><a href="reservierung/final/<?=$formular->id?>">formular <?=$formular->v_num?></a></li>
            <li><span>storno formular</span></li>
        </ul>
    </div>
</div>

<div id="storeno-page" class="reservierung-page content">

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

            <div class="param">
                <span class="param-name">Sachbearbeiter:</span>
                <span class="param-value"><?=$formular->sachbearbeiter->fullname?></span>
            </div>

        </div>
        <br class="clear"/>
    </div>

    <div class="storeno-content">
        <?=form_open("reservierung/storeno/" . $formular->id, null, array("formular_id" => $formular->id));?>

        <div class="storno-form">

            <div class="date-wr">
                <label for="storno-date">Date</label>
                <input type="text" name="date" maxlength="8" id="storno-date"/>
            </div>

            <br class="clear"/>

            <div class="agb-param">
                <div class="agb-item">
                    <label for="agb-value">AGB's %</label>
                    <input type="hidden" name="agb-value" id="agb-value"/>
                    <input type="text" disabled/>
                </div>
                <div class="agb-item manuel">
                    <label for="storno-percent">%</label>
                    <input type="text" id="storno-percent" maxlength="5" name="manuel-percent"/>
                </div>
                <div class="agb-item manuel">
                    <label for="storno-value">Betrag</label>
                    <input type="text" id="storno-value" maxlength="8" name="manuel-value"/>
                </div>

                <br class="clear"/>
            </div>
            <div id="who-radio">
                <input type="radio" name="who"
                       id="type_1" <?=$formular->kunde->type == "agenturen" ? 'checked' : 'disabled'?>
                       value="agenturen"><label
                for="type_1">Agenturen</label>
                <input type="radio" name="who" id="type_2" <?=$formular->kunde->type != "agenturen" ? 'checked' : ''?>
                       value="stammkunden"><label
                for="type_2">Stammkunden</label>
            </div>
            <div class="buttons">
                <a href="reservierung/final/<?=$formular->id?>" class="button-link">Abbrechen</a>
                <input type="submit" id="storno-submit" value="Make Storeno"/>
            </div>
        </div>

        <div id="agb-window" style="display: none">
            <table class="agb-list">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Day Count</th>
                    <th>%</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <? foreach (StornoRule::all() as $ind => $storno_rule): ?>
                <tr>
                    <input type="hidden" class="storno_rule_id" value="<?=$storno_rule->id?>"/>
                    <td><?=($ind + 1)?></td>
                    <td><?=$storno_rule->days?></td>
                    <td><?=$storno_rule->percent?></td>
                    <td><a href="#" class="delete-icon"></a></td>
                </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <button id="new-stornorule">New Rule</button>
        </div>


        </form>
    </div>
</div>

<div id="storno-confirm" style="display:none">
     Are you sure?
 </div>