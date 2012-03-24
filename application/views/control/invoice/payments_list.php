<? if (!$invoice->payments): ?>
<tr>
    <td class="empty" colspan="51">No Zahlung</td>
</tr>
<? else: ?>
<?
    $total = 0;
    foreach ($invoice->payments as $ind => $payment):
        $total += $payment->payment_amount;
        ?>
    <tr class="payment-line">
        <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
        <input type="hidden" class="type" value="<?=$payment->payment_type?>"/>
        <td><?=($ind + 1)?></td>
        <td class="amount"><?=num($payment->payment_amount)?></td>
        <td class="date"><?=$payment->payment_date->format('d.M.y')?></td>
        <td><?=$payment->plain_type?></td>
        <td class="remark"><?=$payment->payment_remark?></td>
        <td>

            <a href="#" class="delete-payment delete-icon"></a>
        </td>
    </tr>
    <? endforeach; ?>
<tr class="total">
    <td>Total</td>
    <td><?=$total?> &euro;</td>
    <td><?=($total < $invoice->amount) ? "-" . ($invoice->amount - $total) : "+" . ($total - $invoice->amount)?> &euro;</td>
    <td colspan="4">&nbsp;</td>
</tr>
<? endif; ?>