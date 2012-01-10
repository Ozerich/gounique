<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></span></li>
            </li>
            <li><span>formular <?=$formular->v_num?></span></li>
        </ul>
    </div>
</div>

<div id="storeno-page" class="reservierung-page content">
    <div class="formular-header">
        <div class="left-block">
            <div class="param">
                <span class="param-name">Kundennummer:</span>
                <a href="#"><?=$formular->kunde->k_num?></a>
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
    <?=form_open("reservierung/storeno/" . $formular->id, null, array("formular_id" => $formular->id));?>

    <div class="form-param">
        <label for="percent">% Client</label>
        <input type="text" id="percent" name="client_percent" length="2" maxlength="2"/>
    </div>

    <div class="form-param">
        <label for="provision">Provision</label>
        <input type="text" id="provision" name="provision" length="2" maxlength="2"/>
    </div>

    <div class="form-param">
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
    </div>

    <button class="btn btn-blue" id="cancel-storeno">Abbrechen</button>
    <input type="submit" class="btn btn-blue" value="Make Storeno"/>

    </form>
</div>