<? if (!$invoice->payments): ?>
<tr>
    <td class="empty" colspan="5">No Zahlung</td>
</tr>
<? else: ?>
<?
    $total = 0;
    foreach ($invoice->payments as $ind => $payment):
        $total += $payment->payment_amount;
        ?>
    <tr>
        <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
        <td><?=($ind + 1)?></td>
        <td><?=$payment->payment_amount?></td>
        <td><?=$payment->payment_date->format('d.M.Y')?></td>
        <td>

            <a href="#" class="delete-payment delete-icon"></a>
        </td>
    </tr>
    <? endforeach; ?>
    <tr class="total">
        <td>Total</td>
        <td><?=$total?> &euro;</td>
        <td><?=($total < $invoice->amount) ? "-".($invoice->amount - $total) : "+".($total - $invoice->amount)?> &euro;</td>
        <td>&nbsp;</td>
    </tr>
<? endif; ?>