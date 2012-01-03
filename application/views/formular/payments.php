<div id="payment-page">
    <table class="payments-list">
        <caption>Payments for formular</caption>
        <thead>
        <th>Num</th>
        <th>Date</th>
        <th>User</th>
        <th>Money</th>
        </thead>
        <tbody>
        <? if (!$formular->payments): ?>
        <tr>
            <td colspan="4" class="nopayments">No payments for this formular</td>
        </tr>
            <? else: ?>
            <? foreach ($formular->payments as $ind => $payment): ?>
            <tr>
                <td class="num"><?=($ind + 1)?></td>
                <td class="date"><?=$payment->datetime->format("d.M.Y h:m")?></td>
                <td class="user"><?=$payment->user->fullname?></td>
                <td class="value"><?=$payment->value?> &euro;</td>
            </tr>
                <? endforeach; ?>
        <tr>
            <td colspan="3" class="total-amount">Total amount</td>
            <td class="total-amount-value"><?=$formular->paid_amount?> &euro;</td>
        </tr>
            <? endif; ?>
        </tbody>
    </table>

    <?=form_open("formular/payments/" . $formular->id);?>
    <div class="newpayment-block">
        <label for="payment-value">Amount: </label>
        <input type="text" maxlength="4" size="4" name="payment_value" id="payment-value"/>
        <input type="submit" value="Add" class="btn btn-blue btn-small"/>
        <br class="clear"/>
    </div>
    </form>

    <a href="formular/<?=$formular->id?>" class="btn btn-blue btn-small">Back</a>
</div>