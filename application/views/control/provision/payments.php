<div id="payments-page">
    <input type="hidden" id="payments_formular_id" value="<?=$formular->id?>"/>
    <a href="#" class="closepopup-button">Close</a>
    <h3>Provision overview for <span class="rnum"><?=$formular->r_num?></span></h3>
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
                <input type="text" id="payment-amount" maxlength="8"/>
            </div>
            <div class="remark-param">
                <label for="payment-remark">Remark:</label>
                <textarea id="payment-remark"></textarea>
            </div>
            <button id="add-payment">Eingabe</button>
        </div>
    </fieldset>

</div>