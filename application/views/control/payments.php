<div id="payments-page">
    <input type="hidden" id="payments_formular_id" value="<?=$formular->id?>"/>

    <h3>Payments overview for <span class="rnum"><?=$formular->r_num?></span></h3>
    <p class="total-payment">Rechnungsbetrag <span class="total-payment-value"><?=$formular->brutto?> &euro;</span></p>
    <div class="payment-content">
        <?=$payments_list?>
    </div>

    <fieldset id="new-payment">
        <legend>New Payment</legend>
        <div class="new-payment-block">
            <div class="param">
                <label for="payment-date">Payment date:</label>
                <input type="text" id="payment-date" maxlength="8"/>
            </div>
            <div class="param">
                <label for="payment-amount">Amount &euro;</label>
                <input type="text" id="payment-amount" maxlength="5"/>
            </div>
            <div class="param">
                <label for="payment-remark">Remark:</label>
                <textarea id="payment-remark"></textarea>
            </div>
            <button id="add-payment">Add Payment</button>
        </div>
    </fieldset>

</div>