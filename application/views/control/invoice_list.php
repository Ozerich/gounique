<? foreach ($formulars as $formular): ?>
<tr>
    <td><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td><?=$formular->created_date->format('d.M.Y')?></td>
    <td><?=$formular->rechnung_date->format('d.M.Y')?></td>
    <td class="reisedatum"><?=$formular->departure_date->format('d.M.Y')?></td>
    <td class="reisedatum"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.Y') : ''?></td>
    <? if ($formular->is_sofort): ?>
    <td class="anzahlung" colspan="3">SOFORT</td>
    <? else: ?>
    <td class="anzahlung"><?=$formular->prepayment_amount?></td>
    <td class="anzahlung"><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.Y') : ''?></td>
    <td class="anzahlung"><?=$formular->anzahlung_status?></td>
    <? endif; ?>
    <td class="restzahlung"><?=$formular->finalpayment_amount?></td>
    <td class="restzahlung"><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.Y') : ''?></td>
    <td class="restzahlung"><?=$formular->restzahlung_status?></td>
    <? if($formular->last_payment): ?>
    <td class="payments"><?=$formular->last_payment->payment_date->format('d.M.Y');?></td>
    <td class="payments"><?=$formular->last_payment->amount;?></td>
    <? else: ?>
        <td colspan="2" class="payments">NO PAYMENTS</td>
    <? endif; ?>
    <td><?=$formular->payment_status?></td>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
