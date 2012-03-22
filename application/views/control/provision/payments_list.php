<div class="top-blocks">
    <div id="provision-block" class="paymentsinfo-block">
        <div class="param">
            <span class="param-name">Provision datum: </span>
            <span><?=$formular->provision_date ? $formular->provision_date->format('d.M.Y'): ''?></span>
        </div>
        <div class="param">
            <span class="param-name">Provision %: </span>
            <span><?=$formular->provision?></span>
        </div>
        <div class="param">
            <span class="param-name">Provision &euro;: </span>
            <span><?=number_format($formular->provision_amount, 2, ',', '.')?></span>
        </div>
        <div class="param">
            <span class="param-name">Provision Status: </span>
            <span><?=$formular->provision_status?></span>
        </div>
    </div>
    <br class="clear"/>
</div>
<table id="payments-table" class="product-list">
    <thead>
    <tr>
        <th>Pay. Date</th>
        <th>Amount</th>
        <th>Diff</th>
        <th>Remark</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>

    <?
    $total = 0;
    $diff = 0;
    foreach ($formular->provision_payments as $payment):
        $total += $payment->amount;

        if ($total == $formular->provision_amount)
            $diff = 0;
        else if ($total < $formular->provision_amount)
            $diff = '-' . ($formular->provision_amount - $total);
        else
            $diff = '+' . ($total - $formular->provision_amount);

        ?>
    <tr>
        <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
        <td class="date"><?=$payment->payment_date->format('d.M.Y');?></td>
        <td class="amount""><?=number_format($payment->amount, 2, ',', '.')?></td>
        <td><?=number_format($diff, 2, ',', '.')?></td>
        <td class="remark"><?=$payment->remark?></td>
        <td>
            <? if ($payment->added_by != 0): ?>
            <a href="#" class="delete-icon delete-payment"></a>
            <? endif; ?>
        </td>
    </tr>
        <? endforeach; ?>
    <tr>
        <td>&nbsp;</td>
        <td class="total-amount"><?=number_format($total, 2, ',', '.')?> &euro;</td>
        <td class="total-amount"><?=number_format($diff, 2, ',', '.')?> &euro;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>

</table>