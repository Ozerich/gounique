<table class="flightpayments-list">
    <thead>
    <th>№</th>
    <th>Payment date</th>
    <th>Payment amount</th>
    <th>Payment type</th>
    <th>Remark</th>
    <th>&nbsp;</th>
    </thead>
    <tbody>
    <? if (!$invoice->payments): ?>
    <tr class="empty">
        <td colspan="10">No payments</td>
    </tr>
        <? else:
        $total_amount = 0;
        foreach ($invoice->payments as $ind => $payment):
            $total_amount += $payment->amount;
            ?>
        <tr>
            <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
            <input type="hidden" class="payment_type" value="<?=$payment->type?>"/>
            <td><?=($ind + 1)?></td>
            <td class="date"><?=$payment->date->format('d.M.y')?></td>
            <td class="amount"><?=num($payment->amount)?></td>
            <td><?=$payment->plain_type?></td>
            <td class="remark"><?=$payment->remark?></td>
            <td><a href="#" class="delete-flightpayment delete-icon"></a></td>
        </tr>
            <? endforeach; ?>
            <tr class="total">
                <td colspan="2">&nbsp;</td>
                <td><?=num($total_amount)?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
        <? endif; ?>
    </tbody>
</table>

<div class="new-flightpayment-wr">
    <a href="#" class="open-flightpayment">New payment</a>

    <div class="newpayment-wr" style="display:none"><form>
        <input type="hidden" name="payment_id" value="<?=$invoice->id?>"/>
        <input type="hidden" class="payment_type" value="<?=$invoice->type?>"/>
        <div class="param">
            <label>Payment date:</label>
            <input type="text" class="payment-date set_datepicker" name="date" maxlength="8"/>
        </div>
        <div class="param">
            <label>Amount &euro;</label>
            <input type="text" id="amount" class="payment-amount" name="amount" maxlength="8"/>
        </div>
        <div class="param">
            <label>Payment type:</label>
            <select class="payment-type" id="type" name="type">
                <? foreach (FlightPayment::$TYPES as $id => $val): ?>
                <option value="<?=$id?>"><?=$val?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="remark-param">
            <label>Remark:</label>
            <textarea id="remark" class="payment-remark" name="remark""></textarea>
        </div>
        <input type="hidden" id="save_payment_id"/>
        <button id="save-payment" style="display: none">Save</button>
        <button class="add_flightpayment-submit">New Payment</button>
    </form></div>
</div>
