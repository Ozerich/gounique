<div id="payments-page">
    <input type="hidden" id="payments_formular_id" value="<?=$formular->id?>"/>
    <h3>Payments for <span class="rnum"><?=$formular->r_num?></span></h3>

    <div class="top-blocks">
        <div class="anzahlung-block info-block">
            <div class="param">
                <label>Anzahlungdatum: </label>
                <span><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.Y') : ''?></span>
            </div>
            <div class="param">
                <label>Anzahlung Amount: </label>
                <span><?=$formular->prepayment_amount?></span>
            </div>
            <div class="param">
                <label>Anzahlung Status: </label>
                <span>OK</span>
            </div>
        </div>
        <div class="anzahlung-block info-block">
            <div class="param">
                <label>Restzahlungdatum: </label>
                <span><?=$formular->finalpayment_date->format('d.M.Y')?></span>
            </div>
            <div class="param">
                <label>Restzahlung Amount: </label>
                <span><?=$formular->finalpayment_amount?></span>
            </div>
            <div class="param">
                <label>Restzahlung Status: </label>
                <span>OK</span>
            </div>
        </div>
        <br class="clear"/>
    </div>
    <table id="payments-table" class="product-list">
        <?=$payments_list?>
    </table>

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