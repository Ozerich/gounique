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
                <span class="param-value" id="vorgangsnummer-value"><?=$formular->v_num?></span>
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

        </div>
        <br class="clear"/>
    </div>

    <div class="storeno-content">
        <?=form_open("reservierung/storeno/" . $formular->id, null, array("formular_id" => $formular->id));?>

        <div class="form-param">
            <label for="percent">Stornogebühr lt. AGB´s %</label>
            <input type="text" id="percent" name="percent" length="3" maxlength="3"/>
        </div>

        <div class="form-param">
            <label for="provision">Date</label>
            <input type="text" id="date" name="date" length="8" maxlength="8"/>
        </div>

        <label>Who</label>

        <div id="who-radio">
            <input type="radio" name="who" id="type_1" <?=$formular->kunde->type == "agenturen" ? 'checked' : 'disabled'?> value="agenturen"><label
            for="type_1">Agenturen</label>
            <input type="radio" name="who" id="type_2" <?=$formular->kunde->type != "agenturen" ? 'checked' : ''?> value="Bausteinreise"><label
            for="type_2">Stammkunden</label>
        </div>
        <div class="buttons">
            <a href="reservierung/final/<?=$formular->id?>" class="button-link">Abbrechen</a>
            <input type="submit" value="Make Storeno"/>
        </div>
        </form>
    </div>
</div>