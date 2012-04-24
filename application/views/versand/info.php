<div id="payments-page">
    <input type="hidden" id="payments_formular_id" value="<?=$formular->id?>"/>
    <a href="#" class="closepopup-button">Close</a>

    <h3>Payments overview for <span class="rnum"><?=$formular->r_num?></span></h3>

    <div class="preview">
        <div class="param">
            <span class="param-name">AG-Num:</span>
            <span class="param-value"><?=$formular->kunde->k_num?></span>
        </div>
        <div class="param">
            <span class="param-name">VG-Num:</span>
            <span class="param-value"><?=$formular->v_num?></span>
        </div>
        <div class="param">
            <span class="param-name">Person:</span>
            <span class="param-value"><?=$formular->person?></span>
        </div>
        <div class="param">
            <span class="param-name">Betrag:</span>
            <span class="param-value"><?=number_format($formular->brutto, 2, ',', '.')?> &euro;</span>
        </div>
        <br class="clear"/>
    </div>
    <div class="versand-block paymentsinfo-block">
        <? if (!$formular->is_storno): ?>
        <p class="versandfreigabe">Versandfreigabe</p>
        <div class="param">
            <span class="param-name">Versended</span>
            <input type="checkbox" id="check_versand" <?=$formular->is_versand ? 'checked' : ''?>/>
        </div>
        <? if ($formular->is_versand): ?>
            <div class="param">
                <span class="param-name">Versended date</span>
                <span><?=$formular->versanded_date->format('d.M.y')?></span>
            </div>
            <div class="param">
                <span class="param-name">Versended By</span>
                <span><?=$formular->versanded_user->fullname?></span>
            </div>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>

<div id="payment-delete-confirm" style="display:none">
    Are you sure?
</div>