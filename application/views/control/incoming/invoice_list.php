<? foreach ($formulars as $ind=>$formular): ?>
<tr>
    <td class="num"><?=($ind + 1)?></td>
    <td class="ag-num">
        <? if($formular->kunde): ?>
        <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
        <? else: ?>
            -
        <? endif; ?>
    </td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td class="reisedatum"><?=$formular->rechnung_date->format('d.M.Y');?></td>
    <td class="reisedatum"><?=$formular->departure_date->format('d.M.Y')?></td>
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

    <td class="storno"><?=$formular->status == 'storno' ? 'STORNO' : ''?></td>
    <td class="versand"><?=$formular->versand_status1?></td>
    <td class="versand"><?=$formular->versand_status2?></td>
    <td class="versand"><?=$formular->is_versand && $formular->is_freigabe ? $formular->versanded_date->format('d.M.Y') : ''?></td>

    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
