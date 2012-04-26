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
    <td class="person"><?=$formular->person?></td>
    <td><?=$formular->departure_date->format('d.M.y')?></td>
    <td class="right reisedatum"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.y') : '-'?></td>
    <td class="right <?=$formular->brutto < 0 ? 'minus' : ''?>"><?=number_format($formular->brutto, 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->provision, 2, ',', '.')?></td>
    <td class="right"><?=$formular->type == 'nurflug' ? 'nurflug' : number_format($formular->provision_amount, 2, ',', '.')?></td>
    <td class="right"><?=$formular->provision_date ? $formular->provision_date->format('d.M.y') : ''?></td>
    <td <?=$formular->payment_netto ? 'class="checkbox"' : ''?>>&nbsp;</td>
    <? if ($formular->is_storno && $formular->status != "rechnung"): ?>
    <td colspan="2" class="storno-status">
        <?= $formular->status == "gutschrift" ? 'GUTSCHRIFT' : 'STORNO' ?>
    </td>
    <? else:
    $provision_status += $formular->provision_status;
    ?>
    <td class="provisionstatus first right <?=$formular->provision_status < 0 ? 'minus' : ''?>"><?=$formular->provision_status >= 0 ? "OK" : num($formular->provision_status)?></td>
    <td class="provisionstatus right"><?=$formular->lastprovision_payment ? $formular->lastprovision_payment->payment_date->format('d.M.y') : '-'?></td>
    <? endif; ?>

    <td class="finance-comment-block no-popup"><div style="position:relative">
        <a class="finance-comment" onmouseout="return hide_comment_baloon(event);" onmouseover="return show_comment_baloon(event);" onclick="return open_comment(event);"></a>
        <div class="finance-new-comment">
            <textarea class="finance-new-comment-text"><?=$formular->payment_provision_comment?></textarea>
            <button class="finance-comment-close" onclick="close_comment(event)">Close</button>
            <button class="finance-comment-save" onclick="save_comment(event, 'provision');">Save</button>
        </div>
        <div class="comment-baloon"><pre><?=$formular->payment_provision_comment?></pre></div></div>
    </td>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
<tr class="total">
    <td colspan="8">&nbsp;</td>
    <td class="right"><?=number_format($total_brutto, 2, ',','.')?></td>
    <td>&nbsp;</td>
    <td class="right"><?=number_format($total_provision, 2, ',','.')?></td>
    <td colspan="2">&nbsp;</td>
    <td class="right"><?=number_format($provision_status, 2, ',','.')?></td>
    <td colspan="5">&nbsp;</td>
</tr>
