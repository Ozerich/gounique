<?
$total_brutto = $total_anzahlung = $total_restzahlung = 0;
foreach ($formulars as $ind => $formular):
    $total_brutto += $formular->brutto;
    $total_anzahlung += $formular->prepayment_amount;
    $total_restzahlung += $formular->finalpayment_amount;
    ?>
<tr>
    <td class="num"><?=($ind + 1)?></td>
    <td class="ag-num">
        <? if ($formular->kunde): ?>
        <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
        <? else: ?>
        -
        <? endif; ?>
    </td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td class="reisedatum"><?=$formular->rechnung_date->format('d.M.Y');?></td>
    <td class="reisedatum"><?=$formular->departure_date->format('d.M.Y')?></td>
    <td class="total"><?=$formular->brutto?></td>
    <? if ($formular->is_sofort): ?>
    <td class="anzahlung" colspan="3">SOFORT</td>
    <? else: ?>
    <td class="anzahlung"><?=$formular->prepayment_amount?></td>
    <td class="anzahlung"><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.y') : ''?></td>
    <td class="anzahlung"><?=$formular->anzahlung_status?></td>
    <? endif; ?>
    <td class="restzahlung"><?=$formular->finalpayment_amount?></td>
    <td class="restzahlung"><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.y') : ''?></td>
    <td class="restzahlung"><?=$formular->restzahlung_status?></td>

    <td class="storno"><?=$formular->status == 'storno' ? 'STORNO' : ''?></td>
    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <td class="versand"><?=$formular->versand_status1?></td>
    <td class="versand"><?=$formular->versand_status2?></td>
    <td class="versand"><?=$formular->is_versand && $formular->is_freigabe ? $formular->versanded_date->format('d.M.y') : ''?></td>

    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
<tr class="total">
    <td colspan="6">&nbsp;</td>
    <td><?=$total_brutto?></td>
    <td><?=$total_anzahlung?></td>
    <td colspan="2">&nbsp;</td>
    <td><?=$total_restzahlung?></td>
    <td colspan="10">&nbsp;</td>
</tr>
