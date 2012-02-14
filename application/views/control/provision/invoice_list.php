<? foreach ($formulars as $ind=>$formular): ?>
<tr>
    <td><?=($ind + 1)?></td>
    <td class="ag-num">
            <? if($formular->kunde): ?>
            <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
            <? else: ?>
                -
            <? endif; ?>
        </td>
    <td><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td><?=$formular->type == 'nurflug' ? 'nurflug' : $formular->provision_amount?></td>
    <td><?=$formular->provision_date ? $formular->provision_date->format('d.M.Y') : ''?></td>
    <td class="provisionstatus"><?=$formular->provision_status?></td>
    <td class="provisionstatus"><?=$formular->lastprovision_payment ? $formular->lastprovision_payment->payment_date->format('d.M.Y') : '-'?></td>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
