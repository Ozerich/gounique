<?
$total_brutto = $total_anzahlung = $total_restzahlung = 0;
foreach ($formulars as $ind => $formular):
    $total_brutto += $formular->brutto;
    $total_anzahlung += $formular->prepayment_amount;
    $total_restzahlung += $formular->finalpayment_amount;
    ?>
<tr>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td class="ag-num">
        <? if ($formular->kunde): ?>
        <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
        <? else: ?>
        -
        <? endif; ?>
    </td>
    <td><?=$formular->v_num?></td>
    <td class="reisedatum"><?=$formular->rechnung_date->format('d.M.Y');?></td>
    <td class="reisedatum"><?=$formular->departure_date->format('d.M.Y')?></td>
    <td class="total"><?=number_format($formular->brutto, 2, ',', '.')?></td>
    <? if ($formular->is_sofort): ?>
    <td class="anzahlung sofort" colspan="3">SOFORT</td>
    <? else: ?>
    <td class="anzahlung"><?=number_format($formular->prepayment_amount,2, ',', '.')?></td>
    <td class="anzahlung"><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.y') : ''?></td>
    <td class="anzahlung"><?=$formular->anzahlung_status?></td>
    <? endif; ?>

    <td class="restzahlung"><?=number_format($formular->finalpayment_amount,2, ',', '.')?></td>
    <td class="restzahlung"><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.y') : ''?></td>
    <td class="restzahlung"><?=$formular->restzahlung_status?></td>

    <td class="storno <?=$formular->is_storno ? 'checkbox' : ''?>">&nbsp;</td>
    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <td class="versand"><?=@number_format($formular->total_diff, 2, ',', '.')?></td>
    <td class="versand <?=$formular->is_freigabe ? 'checkbox' : ''?>">&nbsp;</td>
    <?  if (!$formular->is_freigabe && !$formular->is_versand): ?>
        <td class="versand">&nbsp;</td>
    <? else: ?>
    <td class="versand <?=$formular->is_versand ? 'checkbox' : 'waiting'?>"> <?=$formular->is_versand ? '' : 'waiting'?></td>
    <? endif; ?>
    <td class="versand"><?=$formular->is_versand ? $formular->versanded_date->format('d.M.y') : ''?></td>

    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
<tr class="total">
    <td colspan="5">&nbsp;</td>
    <td><?=number_format($total_brutto,2)?></td>
    <td><?=number_format($total_anzahlung,2)?></td>
    <td colspan="2">&nbsp;</td>
    <td><?=number_format($total_restzahlung,2)?></td>
    <td colspan="10">&nbsp;</td>
</tr>
