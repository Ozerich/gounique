<?
$total_brutto = $total_provision = $provision_status = 0;
foreach ($formulars as $ind => $formular):
    $total_brutto += $formular->brutto;
    $total_provision += $formular->provision_amount;
    ?>
<tr <?=$formular->status == "gutschrift" ? 'class="no-open"' : ''?>>
    <td class="num"><?=($ind + 1)?></td>
    <td><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td class="ag-num">
        <? if ($formular->kunde): ?>
        <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
        <? else: ?>
        -
        <? endif; ?>
    </td>
	<td><?=$formular->plain_ownertype?></td>
    <td><?=$formular->v_num?></td>
    <td class="right <?=$formular->brutto < 0 ? 'minus' : ''?>"><?=number_format($formular->brutto, 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->provision, 2, ',', '.')?></td>
    <td class="right"><?=$formular->type == 'nurflug' ? 'nurflug' : number_format($formular->provision_amount, 2, ',', '.')?></td>
    <td class="right"><?=$formular->provision_date ? $formular->provision_date->format('d.M.y') : ''?></td>
    <td class="storno <?=$formular->is_storno ? 'checkbox' : ''?>">&nbsp;</td>
    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <? if ($formular->is_storno && $formular->status != "rechnung"): ?>
    <td colspan="3" class="storno-status">
        <?= $formular->status == "gutschrift" ? 'GUTSCHRIFT' : 'STORNO' ?>
    </td>
    <? else:
    $provision_status += $formular->provision_status;
    ?>
    <td class="provisionstatus right <?=$formular->provision_status < 0 ? 'minus' : ''?>"><?=$formular->provision_status >= 0 ? "OK" : num($formular->provision_status)?></td>
    <td class="provisionstatus right"><?=$formular->lastprovision_payment ? $formular->lastprovision_payment->payment_date->format('d.M.y') : '-'?></td>
    <? endif; ?>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
<tr class="total">
    <td colspan="4">&nbsp;</td>
    <td class="right"><?=number_format($total_brutto, 2, ',','.')?></td>
    <td>&nbsp;</td>
    <td class="right"><?=number_format($total_provision, 2, ',','.')?></td>
    <td colspan="3">&nbsp;</td>
    <td class="right"><?=number_format($provision_status, 2, ',','.')?></td>
    <td colspan="4">&nbsp;</td>
</tr>
