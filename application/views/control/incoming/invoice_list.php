<?
$total_brutto = $total_anzahlung = $total_restzahlung = $anzahlung_status = $restzahlung_status = $total_diff = 0;
foreach ($formulars as $ind => $formular):
    $total_brutto += $formular->brutto;
    $total_anzahlung += $formular->prepayment_amount;
    $total_restzahlung += $formular->finalpayment_amount;
    $total_diff += $formular->total_diff;
    ?>
<tr class="invoice-line <?=$formular->status == "gutschrift" ? 'no-open' : ''?>">
    <td class="num right"><?=($ind + 1)?></td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td class="ag-num">
        <? if ($formular->kunde): ?>
        <a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->k_num?></a>
        <? else: ?>
        -
        <? endif; ?>
    </td>
    <td><?=$formular->plain_ownertype?>
    <td class="v-num"><?=$formular->v_num?></td>
    <td class="person"><?=$formular->person?></td>
    <td class="right reisedatum"><?=$formular->rechnung_date->format('d.M.y');?></td>
    <td class="right reisedatum"><?=$formular->departure_date->format('d.M.y')?></td>
    <td class="right total <?=$formular->brutto < 0 ? 'minus' : ''?>"><?=number_format($formular->brutto, 2, ',', '.')?></td>
    <? if ($formular->is_sofort): ?>
    <td class="anzahlung sofort" colspan="3">SOFORT</td>
    <? else:
    $anzahlung_status += $formular->anzahlung_status;
    ?>
    <td class="right anzahlung"><?=number_format($formular->prepayment_amount, 2, ',', '.')?></td>
    <td class="right anzahlung"><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.y') : ''?></td>
    <td class="right anzahlung <?=$formular->anzahlung_status < 0 ? 'minus' : ($formular->anzahlung_status > 0 ? 'plus' : '')?>">
        <?=$formular->anzahlung_status >= 0 || $formular->status == "gutschrift" || $formular->status == "storno" ? "OK" : num($formular->anzahlung_status)?>
    </td>
    <? endif; ?>

    <? $restzahlung_status += ($formular->restzahlung_status == "OK" ? 0 : $formular->restzahlung_status);?>
    <td class="right restzahlung"><?=number_format($formular->finalpayment_amount, 2, ',', '.')?></td>
    <td class="right restzahlung"><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.y') : ''?></td>
    <td class="right restzahlung <?=$formular->restzahlung_status < 0 && $formular->status != "gutschrift" ? 'minus' : ($formular->restzahlung_status && $formular->status != "gutschrift" && $formular->status != "storno"  > 0 ? 'plus' : '')?>">
        <?=$formular->restzahlung_status == 0 || $formular->status == "gutschrift" || $formular->status == "storno" ? "OK" : num($formular->restzahlung_status)?>
    </td>

    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <? if ($formular->is_storno): ?>
    <td class="totaldiff right <?=$formular->total_diff < 0 ? 'minus' : ($formular->total_diff > 0 ? 'plus' : '')?>"><?=num($formular->total_diff)?></td>
    <td colspan="3" class="storno-status">
        <? if ($formular->status == "rechnung"): ?>
        StornoRechnung
        <? else: ?>
        <?= $formular->status == "gutschrift" ? 'GUTSCHRIFT' : 'STORNO' ?>
        <? endif; ?>
    </td>
    <? else: ?>
    <td class="right totaldiff <?=$formular->total_diff < 0 ? 'minus' : ($formular->total_diff > 0 ? 'plus' : '')?>"><?=num($formular->total_diff)?></td>
    <td class="versand status <?=$formular->is_freigabe ? 'checkbox' : ''?>">&nbsp;</td>
    <? if (!$formular->is_freigabe && !$formular->is_versand): ?>
        <td class="versand status">&nbsp;</td>
        <? else: ?>
        <td class="versand status <?=$formular->is_versand ? 'checkbox' : 'waiting'?>"> <?=$formular->is_versand ? '' : 'waiting'?></td>
        <? endif; ?>
    <td class="right versand"><?=$formular->is_versand ? $formular->versanded_date->format('d.M.y') : ''?></td>

    <? endif; ?>

    <td class="finance-comment-block no-popup">
        <a class="finance-comment" onmouseout="return hide_comment_baloon(event);" onmouseover="return show_comment_baloon(event);" onclick="return open_comment(event);"></a>
        <div class="finance-new-comment">
            <textarea class="finance-new-comment-text"><?=$formular->payment_incoming_comment?></textarea>
            <button class="finance-comment-close" onclick="close_comment(event)">Close</button>
            <button class="finance-comment-save" onclick="save_comment(event, 'incoming');">Save</button>
        </div>
        <div class="comment-baloon"><pre><?=$formular->payment_incoming_comment?></pre></div>
    </td>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>

<tr class="comment" style="display:none">
    <td colspan="20"><?=$formular->comment?></td>
</tr>

<? endforeach; ?>
<tr class="total">
    <td colspan="7">&nbsp;</td>
    <td><?=number_format($total_brutto, 2, ',', '.')?></td>
    <td><?=number_format($total_anzahlung, 2, ',', '.')?></td>
    <td>&nbsp;</td>
    <td><?=number_format($anzahlung_status, 2, ',', '.')?></td>
    <td><?=number_format($total_restzahlung, 2)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($restzahlung_status, 2)?></td>
    <td colspan="2">&nbsp;</td>
    <td><?=number_format($total_diff, 2)?></td>
    <td colspan="6">&nbsp;</td>
</tr>
