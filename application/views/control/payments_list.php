<thead>
<tr>
    <th>Pay. Date</th>
    <th>Amount</th>
    <th>Anzahlung Diff</th>
    <th>Restzahlung Diff</th>
    <th>Remark</th>
    <th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?
$total = 0;
$anzahlung = $formular->prepayment_amount;
$restzahlung = $formular->finalpayment_amount;
$anzahlung_diff = $restzahlung_diff = 0;
foreach ($formular->payments as $payment):
    $total += $payment->amount;

    if ($anzahlung - $total < 0)
        $anzahlung_diff = 0;
    else
        $anzahlung_diff = '-' . ($anzahlung - $total);

    if($anzahlung - $total >= 0)
        $restzahlung_diff = '-'.$restzahlung;
    else{
        $my_restzahlung = $total - $anzahlung;
        if($restzahlung - $my_restzahlung < 0)
        $restzahlung_diff = '+'.($my_restzahlung - $restzahlung);
    else
        $restzahlung_diff = '-' . ($restzahlung - $my_restzahlung);
    }
    ?>
<tr>
    <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
    <td><?=$payment->payment_date->format('d.M.Y');?></td>
    <td><?=$payment->amount?></td>
    <td><?=$anzahlung_diff?></td>
    <td><?=$restzahlung_diff?></td>
    <td><?=$payment->remark?></td>
    <td><a href="#" class="delete-icon delete-payment"></a></td>
</tr>
    <? endforeach; ?>
<tr>
    <td>&nbsp;</td>
    <td class="total-amount"><?=$total?> &euro;</td>
    <td>&nbsp;</td>
    <td class="total-amount"><?=$restzahlung_diff?> &euro;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</tbody>