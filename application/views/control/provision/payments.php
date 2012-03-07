<div id="payments-page">
    <input type="hidden" id="payments_formular_id" value="<?=$formular->id?>"/>
    <a href="#" class="closepopup-button">Close</a>
    <h3>Provision overview for <span class="rnum"><?=$formular->r_num?></span></h3>
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

   <div class="payment-content">
        <?=$payments_list?>
    </div>


<? if($formular->status == "rechnung"): ?>
    <fieldset id="new-payment">
        <legend>New Payment</legend>
        <div class="new-payment-block">
            <div class="param">
                <label for="payment-date">Payment date:</label>
                <input type="text" id="payment-date" maxlength="8"/>
            </div>
            <div class="param">
                <label for="payment-amount">Amount &euro;</label>
                <input type="text" id="payment-amount" maxlength="8"/>
            </div>
            <div class="remark-param">
                <label for="payment-remark">Remark:</label>
                <textarea id="payment-remark"></textarea>
            </div>
            <button id="add-payment">Eingabe</button>
        </div>
    </fieldset>
<? endif; ?>
</div>

<div id="payment-delete-confirm" style="display:none">
    Are you sure?
</div>