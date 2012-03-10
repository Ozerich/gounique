<?
$total_brutto = $total_anzahlung = $total_restzahlung = $anzahlung_status = $restzahlung_status = $total_diff = 0;
foreach ($formulars as $ind => $formular):
    $total_brutto += $formular->brutto;
    $total_anzahlung += $formular->prepayment_amount;
    $total_restzahlung += $formular->finalpayment_amount;
    $total_diff += $formular->total_diff;
    ?>
<tr <?=$formular->status == "gutschrift" ? 'class="no-open"' : ''?>>
    <td class="num"><?=($ind + 1)?></td>
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
    <td class="total <?=$formular->brutto < 0 ? 'minus' : ''?>"><?=number_format($formular->brutto, 2, ',', '.')?></td>
    <? if ($formular->is_sofort): ?>
    <td class="anzahlung sofort" colspan="3">SOFORT</td>
    <? else:
    $anzahlung_status += $formular->anzahlung_status;
    ?>
    <td class="anzahlung"><?=number_format($formular->prepayment_amount, 2, ',', '.')?></td>
    <td class="anzahlung"><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.y') : ''?></td>
    <td class="anzahlung <?=$formular->anzahlung_status < 0 ? 'minus' : ''?>">
        <?=$formular->anzahlung_status >= 0 || $formular->status == "gutschrift" ? "OK" : num($formular->anzahlung_status)?>
    </td>
    <? endif; ?>

    <? $restzahlung_status += ($formular->restzahlung_status == "OK" ? 0 : $formular->restzahlung_status);?>
    <td class="restzahlung"><?=number_format($formular->finalpayment_amount, 2, ',', '.')?></td>
    <td class="restzahlung"><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.y') : ''?></td>
    <td class="restzahlung <?=$formular->restzahlung_status < 0 && $formular->status != "gutschrift" ? 'minus' : ''?>">
        <?=$formular->restzahlung_status >= 0 || $formular->status == "gutschrift" ? "OK" : num($formular->restzahlung_status)?>
    </td>

    <td class="storno <?=$formular->is_storno ? 'checkbox' : ''?>">&nbsp;</td>
    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <? if ($formular->is_storno): ?>
    <td class="versand right"><?=num(0)?></td>
    <td colspan="3" class="storno-status">
        <? if ($formular->status == "rechnung"): ?>
        StornoRechnung
        <? else: ?>
        <?= $formular->status == "gutschrift" ? 'GUTSCHRIFT' : 'STORNO' ?>
        <? endif; ?>
    </td>
    <? else: ?>
    <td class="versand right <?=$formular->total_diff ? 'minus' : ''?>"><?=num($formular->total_diff)?></td>
    <td class="versand <?=$formular->is_freigabe ? 'checkbox' : ''?>">&nbsp;</td>
    <? if (!$formular->is_freigabe && !$formular->is_versand): ?>
        <td class="versand">&nbsp;</td>
        <? else: ?>
        <td class="versand <?=$formular->is_versand ? 'checkbox' : 'waiting'?>"> <?=$formular->is_versand ? '' : 'waiting'?></td>
        <? endif; ?>
    <td class="versand"><?=$formular->is_versand ? $formular->versanded_date->format('d.M.y') : ''?></td>

    <? endif; ?>

    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? if ($formular->comment): ?>
<tr class="comment" style="display:none">
    <td colspan="20"><?=$formular->comment?></td>
</tr>
<? endif; ?>
<? endforeach; ?>
<tr class="total">
    <td colspan="6">&nbsp;</td>
    <td><?=number_format($total_brutto, 2, ',', '.')?></td>
    <td><?=number_format($total_anzahlung, 2, ',', '.')?></td>
    <td>&nbsp;</td>
    <td><?=number_format($anzahlung_status, 2, ',', '.')?></td>
    <td><?=number_format($total_restzahlung, 2)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($restzahlung_status, 2)?></td>
    <td colspan="2">&nbsp;</td>
    <td><?=number_format($total_diff, 2)?></td>
    <td colspan="5">&nbsp;</td>
</tr>
