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
            <td><?=($ind + 1)?></td>
            <td><?=$payment->date->format('d.M.Y')?></td>
            <td><?=num($payment->amount)?></td>
            <td><?=$payment->plain_type?></td>
            <td><?=$payment->remark?></td>
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
        <input type="hidden" name="invoice_id" value="<?=$invoice->id?>"/>
        <div class="param">
            <label>Payment date:</label>
            <input type="text" class="payment-date set_datepicker" name="date" maxlength="8"/>
        </div>
        <div class="param">
            <label>Amount &euro;</label>
            <input type="text" class="payment-amount" name="amount" maxlength="8"/>
        </div>
        <div class="param">
            <label>Payment type:</label>
            <select class="payment-type" name="type">
                <? foreach (FlightPayment::$TYPES as $id => $val): ?>
                <option value="<?=$id?>"><?=$val?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="remark-param">
            <label>Remark:</label>
            <textarea class="payment-remark" name="remark""></textarea>
        </div>
        <button class="add_flightpayment-submit">Add Payment</button>
    </form></div>
</div>
